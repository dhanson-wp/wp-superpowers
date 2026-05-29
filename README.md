# WP Superpowers

WP Superpowers is an add-on pack for established WordPress agent skills.

The default WordPress skills teach the base domains: blocks, themes, plugins, REST, Interactivity API, Playground, WP-CLI, performance, and project triage. WP Superpowers starts after that. It captures the higher-level moves that came from using those skills in real WordPress practice: sharper defaults, stronger quality gates, better verification loops, and clearer handoffs between humans and agents.

Use it when a task is no longer just "build a block" or "make a plugin screen," but something more specific:

- compose a custom Gutenberg editor outside the post editor
- make a DataViews/DataForm admin screen feel truly native and complete
- run a plugin release-quality review, not just a syntax pass
- generate block markup while delegating validation to an existing MCP/tool
- prove a feature in Playground with screenshots, reload checks, and console checks
- practice an Interactivity API concept without turning it into a bloated demo

## Source Order

When an add-on depends on current WordPress behavior, use this order:

1. Local project code and installed package versions.
2. Local Gutenberg checkout, when available.
3. WordPress core and Gutenberg source.
4. Official WordPress developer documentation and Developer Blog.
5. Established WordPress agent skills, including [WordPress/agent-skills](https://github.com/WordPress/agent-skills) when available.
6. This add-on pack.

Source still wins. WP Superpowers supplies the extra operating judgment.

## How To Use

Clone and inspect:

```bash
git clone https://github.com/dhanson-wp/wp-superpowers.git
cd wp-superpowers
ls skills
node eval/harness/run.mjs
```

Install into a project with Node:

```bash
node shared/scripts/skillpack-install.mjs --dest=../your-wp-project --targets=codex,claude
```

Install selected skills globally:

```bash
node shared/scripts/skillpack-install.mjs --global --targets=codex --skills=wp-custom-block-editor,wp-plugin-quality-gate
```

Install into a Composer-managed WordPress project:

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

For an agent:

```text
Use WP Superpowers as an add-on pack for WordPress agent skills.
Read AGENTS.md first.
Use the default WordPress skill for the base domain first.
Then read the matching WP Superpowers add-on in skills/<skill-name>/SKILL.md.
Inspect the target project, implement with WordPress-native APIs, run the verification gate, and report what changed.
```

## Repository Map

- `skills/` - portable skill bundles, each with `SKILL.md`, `references/`, and optional `scripts/`.
- `eval/scenarios/` - prompt-style scenarios that describe expected agent behavior.
- `shared/scripts/` - helper scripts for scaffolding, installing, and future packaging.
- `examples/` - small public-safe reference implementations.
- `verification/` - browser, Playground, and release-readiness gates.
- `src/Installer.php` - optional Composer installer for project-local skill copies.

## Add-on Skills

| Add-on skill | Builds on | What it adds |
| --- | --- | --- |
| `wp-custom-block-editor` | `wp-block-development`, `wp-rest-api`, `wp-playground` | Product-grade Gutenberg editor composition outside the post editor |
| `wp-admin-dataviews-dataform` | `wp-plugin-development`, `wp-rest-api`, `wpds` | Complete wp-admin interaction coverage and visual quality gates for DataViews/DataForm |
| `wp-plugin-quality-gate` | `wp-plugin-development`, `wp-rest-api`, `wp-block-development` | Release-minded plugin contract, lifecycle, retention, security, and artifact review |
| `wp-block-markup` | block-markup MCP/tools, block/theme skills | Conservative block markup generation plus external validation workflow |
| `wp-playground-verification` | `wp-playground` | Disposable proof loops with activation, target URL, console, interaction, reload, and screenshot checks |
| `wp-interactivity-practice-loop` | `wp-interactivity-api`, `wp-playground` | Small faithful Interactivity API reps plus one useful variation and frontend verification |

## Gitignore

When installed into a project, these skill folders are generated copies. Add the installed add-ons to the consuming project's `.gitignore` unless you intentionally want to commit them:

```gitignore
.claude/skills/wp-*/
.codex/skills/wp-*/
.cursor/skills/wp-*/
.github/skills/wp-*/
```

## License

Code examples are intended to be GPL-compatible for WordPress use. See `LICENSE`.
