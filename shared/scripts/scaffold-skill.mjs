import fs from "node:fs";
import path from "node:path";

function usage() {
  process.stderr.write(
    [
      "Usage:",
      '  node shared/scripts/scaffold-skill.mjs <skill-name> "<description>"',
      "",
      "Creates:",
      "- skills/<skill-name>/SKILL.md",
      "- skills/<skill-name>/references/guide.md",
      "- eval/scenarios/<skill-name>.json",
      "",
    ].join("\n")
  );
}

function assert(condition, message) {
  if (!condition) throw new Error(message);
}

function validateSkillName(name) {
  if (!name || typeof name !== "string") return "Missing skill name";
  if (name.length > 64) return `Skill name exceeds 64 chars (${name.length})`;
  if (name !== name.toLowerCase()) return "Skill name must be lowercase";
  if (name.startsWith("-") || name.endsWith("-")) return "Skill name cannot start or end with hyphen";
  if (name.includes("--")) return "Skill name cannot contain consecutive hyphens";
  return /^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(name) ? null : "Skill name contains invalid characters";
}

const [, , skillName, description] = process.argv;
if (!skillName || !description) {
  usage();
  process.exit(2);
}

const nameError = validateSkillName(skillName);
assert(!nameError, nameError);

const repoRoot = process.cwd();
const skillDir = path.join(repoRoot, "skills", skillName);
const referencesDir = path.join(skillDir, "references");
assert(!fs.existsSync(skillDir), `Skill already exists: ${path.relative(repoRoot, skillDir)}`);
fs.mkdirSync(referencesDir, { recursive: true });

const skillMd = `---\nname: ${skillName}\ndescription: "${description}"\ncompatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node."\n---\n\n# ${skillName}\n\n## When to use\n\n## Inputs required\n\n## Procedure\n\n1. Inspect the target project.\n2. Read \`references/guide.md\`.\n3. Implement using WordPress-native APIs.\n4. Run verification.\n\n## Verification\n\n## Failure modes / debugging\n\n## Escalation\n`;
fs.writeFileSync(path.join(skillDir, "SKILL.md"), skillMd, "utf8");
fs.writeFileSync(path.join(referencesDir, "guide.md"), `# ${skillName} Guide\n`, "utf8");

const scenario = {
  name: skillName,
  skills: [skillName],
  query: "",
  expected_behavior: [`Uses ${skillName} when the prompt matches its description.`],
  success_criteria: ["Follows the skill procedure and verifies results."]
};
fs.mkdirSync(path.join(repoRoot, "eval", "scenarios"), { recursive: true });
fs.writeFileSync(path.join(repoRoot, "eval", "scenarios", `${skillName}.json`), `${JSON.stringify(scenario, null, 2)}\n`, "utf8");

process.stdout.write(`Created ${path.relative(repoRoot, skillDir)}\n`);
