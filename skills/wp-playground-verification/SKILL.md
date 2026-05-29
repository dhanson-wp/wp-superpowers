---
name: wp-playground-verification
description: "Use when proving WordPress plugin, block, admin-screen, block-markup, or theme work in a disposable WordPress Playground environment with activation, target URL checks, console checks, interaction, screenshots, and reproducible blueprints."
compatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node. Requires WordPress Playground CLI or browser Playground when available."
---

# WP Playground Verification

## When to use

Use this add-on after the base Playground skill when you need a fast disposable WordPress proof for:

- practice plugins
- admin screens
- block markup
- block/theme templates
- screenshots
- bug reproduction

Use the default `wp-playground` skill for exact Playground CLI commands when available. This add-on defines the proof loop: activation, target URL, console, interaction, reload, and screenshots/reports.

## Inputs required

- Plugin/theme/content path to mount.
- Target WordPress and PHP version if relevant.
- Landing page or admin URL.
- Login/admin needs.
- Blueprint file path, if present or needed.

## Procedure

1. Inspect the project for existing Playground config.
2. Read `references/guide.md`.
3. Mount the target plugin/theme/content.
4. Activate what needs activation.
5. Navigate to the target admin or frontend screen.
6. Check console output.
7. Exercise the workflow.
8. Capture screenshots or JSON reports for non-trivial UI work.

## Verification

- Environment starts.
- Plugin/theme activates.
- Target screen loads.
- Assets enqueue correctly.
- Console is clean or known warnings are documented.
- Interaction works.
- Screenshots/reports capture the final state when useful.

## Failure modes / debugging

- Testing source without mounting built assets.
- Assuming activation succeeded without checking wp-admin/plugins.
- Ignoring console/runtime errors.
- Treating a screenshot as proof of persistence without reload.

## Escalation

If Playground cannot model the production environment, document the limitation and run the closest local WordPress verification available.
