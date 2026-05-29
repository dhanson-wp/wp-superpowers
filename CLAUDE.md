# Claude Guide

This repo is an add-on pack for established WordPress agent skills.

When asked to use WP Superpowers:

1. Read `AGENTS.md`.
2. Use the default WordPress skill for the base domain first.
3. Read the relevant WP Superpowers add-on in `skills/<skill-name>/SKILL.md`.
4. Read only the referenced files under that skill's `references/`.
5. Inspect the target codebase before editing.
6. Prefer WordPress-native APIs, packages, and UI grammar.
7. Run the verification gate from the add-on skill.
8. Explain what you changed and what still needs human review.

Do not treat example code as a package to vendor blindly. Use it as a reference implementation and adapt it to the target project's architecture.
