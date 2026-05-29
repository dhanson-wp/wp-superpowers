---
name: wp-interactivity-practice-loop
description: "Use when learning, prototyping, or verifying WordPress Interactivity API behavior through small server-rendered blocks with data-wp directives, scoped state/actions, Playground checks, and one useful variation."
compatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node. Interactivity API behavior must be checked against the target WordPress/Gutenberg version."
---

# WP Interactivity Practice Loop

## When to use

Use this add-on after the base Interactivity API skill for focused practice or prototype work:

- server-rendered interactive blocks
- `data-wp-*` directive behavior
- stores, state, actions, callbacks
- accessible frontend interaction
- small verified variations

Use the default `wp-interactivity-api` skill as the API authority first. This add-on adds the practice loop: smallest faithful example, one useful variation, and frontend verification.

## Inputs required

- Target block/plugin path.
- Interaction to prove.
- Target WordPress/Gutenberg version.
- Frontend URL or Playground blueprint.
- Required variation, if any.

## Procedure

1. Inspect the target project and existing block structure.
2. Use the default `wp-interactivity-api` skill for API-level details when available.
3. Read `references/guide.md`.
4. Build or update the smallest faithful example first.
5. Keep markup server-rendered where possible.
6. Add directive attributes to meaningful HTML.
7. Keep state and actions scoped.
8. Add one useful variation after the faithful behavior works.
9. Verify in Playground or a real WordPress environment.

## Verification

- Block registers and renders.
- Markup is meaningful before JavaScript behavior.
- Directives update expected state.
- Pointer and keyboard interactions work.
- Console is clean.
- Behavior survives reload.
- Active theme still renders the block acceptably.

## Failure modes / debugging

- Building a standalone React app instead of a WordPress interactive block.
- Skipping frontend verification.
- Hiding state changes behind color or motion only.
- Letting a practice plugin grow too large to teach one concept clearly.

## Escalation

If directive behavior differs from expectations, inspect the exact WordPress/Gutenberg package source for the target environment.
