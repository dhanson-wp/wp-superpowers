import fs from "node:fs";
import os from "node:os";
import path from "node:path";

const repoRoot = process.cwd();
const skillsRoot = path.join(repoRoot, "skills");

function usage() {
  process.stderr.write(
    [
      "Usage:",
      "  node shared/scripts/skillpack-install.mjs --list",
      "  node shared/scripts/skillpack-install.mjs --dest=../my-wp-project --targets=codex,claude,cursor",
      "  node shared/scripts/skillpack-install.mjs --global --targets=codex",
      "",
      "Options:",
      "  --skills=a,b       Install only selected skills",
      "  --dry-run          Print actions without copying",
      "",
    ].join("\n")
  );
}

function parseArgs(argv) {
  const args = {};
  for (const item of argv) {
    if (item === "--list") args.list = true;
    else if (item === "--global") args.global = true;
    else if (item === "--dry-run") args.dryRun = true;
    else if (item.startsWith("--dest=")) args.dest = item.slice("--dest=".length);
    else if (item.startsWith("--targets=")) args.targets = item.slice("--targets=".length).split(",").filter(Boolean);
    else if (item.startsWith("--skills=")) args.skills = item.slice("--skills=".length).split(",").filter(Boolean);
    else throw new Error(`Unknown option: ${item}`);
  }
  return args;
}

function listSkills() {
  return fs
    .readdirSync(skillsRoot, { withFileTypes: true })
    .filter((entry) => entry.isDirectory())
    .map((entry) => entry.name)
    .sort();
}

function targetDir(target, destination, isGlobal) {
  const home = os.homedir();
  if (isGlobal) {
    if (target === "codex") return path.join(home, ".codex", "skills");
    if (target === "claude") return path.join(home, ".claude", "skills");
    if (target === "cursor") return path.join(home, ".cursor", "skills");
    throw new Error(`Global target not supported: ${target}`);
  }
  if (target === "codex") return path.join(destination, ".codex", "skills");
  if (target === "claude") return path.join(destination, ".claude", "skills");
  if (target === "cursor") return path.join(destination, ".cursor", "skills");
  if (target === "vscode" || target === "copilot") return path.join(destination, ".github", "skills");
  throw new Error(`Unknown target: ${target}`);
}

const args = parseArgs(process.argv.slice(2));
const allSkills = listSkills();

if (args.list) {
  process.stdout.write(`${allSkills.join("\n")}\n`);
  process.exit(0);
}

const selected = args.skills ?? allSkills;
for (const skill of selected) {
  if (!allSkills.includes(skill)) throw new Error(`Unknown skill: ${skill}`);
}

const targets = args.targets ?? ["codex", "claude"];
const destination = args.global ? null : path.resolve(repoRoot, args.dest ?? ".");

for (const target of targets) {
  const outRoot = targetDir(target, destination, Boolean(args.global));
  for (const skill of selected) {
    const source = path.join(skillsRoot, skill);
    const dest = path.join(outRoot, skill);
    process.stdout.write(`${args.dryRun ? "DRY " : ""}COPY ${path.relative(repoRoot, source)} -> ${dest}\n`);
    if (!args.dryRun) {
      fs.mkdirSync(outRoot, { recursive: true });
      fs.rmSync(dest, { recursive: true, force: true });
      fs.cpSync(source, dest, { recursive: true });
    }
  }
}
