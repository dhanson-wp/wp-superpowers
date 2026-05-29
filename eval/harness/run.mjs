import fs from "node:fs";
import path from "node:path";

function assert(condition, message) {
  if (!condition) throw new Error(message);
}

function parseFrontmatter(markdown) {
  const lines = markdown.split("\n");
  if (lines[0]?.trim() !== "---") return null;
  const end = lines.findIndex((line, index) => index > 0 && line.trim() === "---");
  if (end === -1) return null;
  const data = {};
  for (const line of lines.slice(1, end)) {
    const match = line.match(/^([A-Za-z0-9_-]+):\s*(.*)$/);
    if (!match) continue;
    data[match[1]] = match[2].replace(/^"(.*)"$/, "$1").trim();
  }
  return data;
}

const repoRoot = process.cwd();
const skillsRoot = path.join(repoRoot, "skills");
const scenarioRoot = path.join(repoRoot, "eval", "scenarios");

assert(fs.existsSync(skillsRoot), "Missing skills/ directory");
assert(fs.existsSync(scenarioRoot), "Missing eval/scenarios/ directory");

const skillDirs = fs
  .readdirSync(skillsRoot, { withFileTypes: true })
  .filter((entry) => entry.isDirectory())
  .map((entry) => entry.name)
  .sort();

assert(skillDirs.length > 0, "No skills found");

for (const skillName of skillDirs) {
  const skillPath = path.join(skillsRoot, skillName, "SKILL.md");
  assert(fs.existsSync(skillPath), `Missing ${path.relative(repoRoot, skillPath)}`);
  const markdown = fs.readFileSync(skillPath, "utf8");
  const frontmatter = parseFrontmatter(markdown);
  assert(frontmatter, `Missing YAML frontmatter in ${path.relative(repoRoot, skillPath)}`);
  assert(frontmatter.name === skillName, `Frontmatter name mismatch in ${path.relative(repoRoot, skillPath)}`);
  assert(frontmatter.description, `Missing description in ${path.relative(repoRoot, skillPath)}`);
  assert(frontmatter.compatibility, `Missing compatibility in ${path.relative(repoRoot, skillPath)}`);
  assert(frontmatter.compatibility.includes("WordPress 6.9"), `Compatibility must mention WordPress 6.9 in ${skillName}`);
  assert(frontmatter.compatibility.includes("PHP 7.2.24"), `Compatibility must mention PHP 7.2.24 in ${skillName}`);
  for (const section of ["## When to use", "## Inputs required", "## Procedure", "## Verification", "## Failure modes / debugging", "## Escalation"]) {
    assert(markdown.includes(section), `Missing section '${section}' in ${skillName}`);
  }
  const scenarioPath = path.join(scenarioRoot, `${skillName}.json`);
  assert(fs.existsSync(scenarioPath), `Missing eval scenario for ${skillName}`);
  const scenario = JSON.parse(fs.readFileSync(scenarioPath, "utf8"));
  assert(Array.isArray(scenario.skills) && scenario.skills.includes(skillName), `Scenario must include ${skillName}`);
  assert(Array.isArray(scenario.expected_behavior), `Scenario missing expected_behavior[] for ${skillName}`);
  assert(Array.isArray(scenario.success_criteria), `Scenario missing success_criteria[] for ${skillName}`);
}

process.stdout.write(`OK: validated ${skillDirs.length} skills and scenarios.\n`);
