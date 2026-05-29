# Installation

WP Superpowers can be used directly from a clone, installed into a WordPress project, or copied into global assistant skill folders.

## Clone And Inspect

```bash
git clone https://github.com/dhanson-wp/wp-superpowers.git
cd wp-superpowers
ls skills
npm run validate
```

## Project-Local Install

Install all add-on skills into a project for Codex and Claude:

```bash
node shared/scripts/skillpack-install.mjs --dest=../your-wp-project --targets=codex,claude
```

Install only selected skills:

```bash
node shared/scripts/skillpack-install.mjs --dest=../your-wp-project --targets=codex --skills=wp-custom-block-editor,wp-plugin-quality-gate
```

## Global Install

Install selected skills into the current user's global assistant skill folder:

```bash
node shared/scripts/skillpack-install.mjs --global --targets=codex --skills=wp-custom-block-editor,wp-plugin-quality-gate
```

## Composer-Managed Projects

Add the package as a VCS repository in a WordPress project's `composer.json`:

```json
{
	"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/dhanson-wp/wp-superpowers"
		}
	],
	"require-dev": {
		"dhanson-wp/wp-superpowers": "dev-main"
	},
	"scripts": {
		"post-install-cmd": [
			"WPSuperpowers\\Installer::install"
		],
		"post-update-cmd": [
			"WPSuperpowers\\Installer::install"
		]
	},
	"extra": {
		"wp-superpowers": {
			"skills": {
				"paths": [ ".claude/skills", ".codex/skills" ]
			}
		}
	}
}
```

Then run:

```bash
composer install
```

## Generated Skill Folders

The installer copies skills into assistant-specific folders. In most consuming projects, those folders are generated local tooling and should not be committed unless the project intentionally vendors its agent skills.

Common generated paths:

```gitignore
.claude/skills/wp-*/
.codex/skills/wp-*/
.cursor/skills/wp-*/
.github/skills/wp-*/
```

Keep those entries in the consuming project's `.gitignore` when the installed copies are local developer tooling. Commit them only when the project wants to share the exact skill pack with every contributor.
