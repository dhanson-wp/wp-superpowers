---
name: wp-plugin-quality-gate
description: "Use before implementing, reviewing, or shipping WordPress plugin code to verify bootstrap, lifecycle, owned data, storage, write permissions, validation, sanitization, escaping, REST schema, blocks, cron, accessibility, and release readiness."
compatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node. Some checks require WP-CLI, Composer, npm, or Plugin Check when available."
---

# WP Plugin Quality Gate

## When to use

Use this add-on after the base plugin-development skills when the task needs release-minded review, not just implementation help.

Use it:

- before starting a plugin feature
- before reviewing plugin code
- before shipping a plugin artifact
- when adding write paths, REST endpoints, blocks, admin screens, cron, or external services

Use the default `wp-plugin-development` skill first when the task involves general plugin architecture. This add-on raises the bar for lifecycle, retention, permissions, release artifacts, and human-review risk.

## Inputs required

- Plugin root and main file.
- Owned data and retention/uninstall policy.
- Write paths and required capabilities.
- Storage choice.
- Public surfaces: admin, REST, blocks, shortcodes, cron, CLI, MCP.
- Available project checks: PHP lint, Composer, npm, PHPUnit, Playwright, Plugin Check.

## Procedure

1. Inspect plugin structure and existing checks.
2. Use default `wp-plugin-development`, `wp-rest-api`, `wp-block-development`, and `wp-wpcli-and-ops` skills when those domains apply.
3. Read `references/guide.md`.
4. Name the plugin contract before editing:
   - bootstrap responsibilities
   - owned data
   - storage
   - write permissions
   - public surfaces
   - hook contracts
   - retention/uninstall policy
   - verification plan
5. Verify lifecycle behavior separately:
   - activation
   - deactivation
   - uninstall
6. For every write path, check capability, intent, validation, sanitization, and late escaping.
7. For REST/MCP surfaces, require schema, permission callbacks, stable handles, next actions, and recovery notes.

## Verification

- PHP syntax checks pass.
- Plugin activates.
- Plugin deactivates without deleting durable data.
- Uninstall behavior matches policy.
- Write paths check capabilities and intent.
- Inputs validate and sanitize.
- Output escapes late for context.
- REST endpoints have schemas and permission callbacks.
- Blocks use `block.json` and generated asset metadata.
- Cron unschedules correctly.
- Admin and frontend states are accessible.
- Release artifacts include required source/build files.

## Failure modes / debugging

- Fat main plugin file.
- Unprefixed global functions.
- Deleting durable data on deactivation.
- Treating nonce checks as authorization.
- Confusing sanitization with escaping.
- Choosing custom tables before proving query/relational need.
- Shipping without activation/deactivation/uninstall smoke checks.

## Escalation

Ask for human review on product intent, threat model, retention/privacy, accessibility nuance, performance budget, compatibility promises, and release timing.
