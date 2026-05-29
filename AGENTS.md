# Agent Instructions

Use this repository as an add-on pack for established WordPress agent skills.

## Operating Rule

Do not start here for broad WordPress basics. Start with the default WordPress skill for the base domain, then use WP Superpowers for the extra product judgment, verification gate, or workflow refinement.

## Source Order

1. Target project code.
2. Target project's installed package versions.
3. Local Gutenberg checkout if available.
4. WordPress core/Gutenberg source and official docs.
5. Established WordPress agent skills, including `WordPress/agent-skills` when available.
6. WP Superpowers add-on skills.

## Workflow

1. Identify the base WordPress domain: block editor, Interactivity API, DataViews/DataForm, plugin architecture, REST, block markup, Playground, release.
2. Use the established WordPress skill for that base domain first.
3. Read the matching WP Superpowers add-on in `skills/<skill-name>/SKILL.md`.
4. Read only the referenced files under that skill's `references/`.
5. Inspect the target project.
6. Implement with WordPress-native APIs before bespoke abstractions.
7. Run the add-on skill's verification gate.
8. Report files changed, checks run, remaining risk, and any source behavior that disagreed with the add-on.

## Defaults

- Prefer WordPress primitives and Gutenberg packages over generic UI or state libraries.
- Preserve wp-admin grammar in admin screens.
- Keep plugin bootstraps thin and behavior behind testable boundaries.
- Treat capability checks, nonce/intent checks, validation, sanitization, and late escaping as separate concerns.
- Store block grammar with `serialize()` and hydrate with `parse()` when building custom block editors.
- Verify in WordPress Playground or a real WordPress environment when possible.
- Do not copy project-specific references, screenshots, or third-party branding into public artifacts.

## Agent Compatibility

Codex and Claude should both be able to use this repo.

- Codex: read `AGENTS.md`, then use the relevant add-on in `skills/<skill-name>/SKILL.md`.
- Claude: read `CLAUDE.md`, then use the same canonical files.
- Other agents: start from `README.md` and use the add-on skill bundles.
