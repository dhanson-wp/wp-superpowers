# Playground Verification

Status: `candidate`

Use WordPress Playground as the fast disposable proof environment for plugin, block, admin-screen, and content-pattern work.

## Problem

WordPress work can look correct in source while failing at activation, enqueue, REST, editor, or frontend runtime. A disposable WordPress environment catches those failures cheaply.

## Use When

- Testing practice plugins.
- Verifying admin screens.
- Checking block markup or templates.
- Capturing screenshots for review.
- Reproducing a bug without touching a real site.

## Implementation Shape

- Keep a `blueprint.json` near each example when it improves reproducibility.
- Mount the plugin or theme.
- Log in when admin/editor verification is needed.
- Open the target admin or frontend URL.
- Use browser automation for console checks and screenshots.

## Verification Gate

- Environment starts.
- Plugin/theme activates.
- Target screen loads.
- Assets enqueue correctly.
- Console is clean.
- Interaction works.
- Screenshots or JSON reports capture the result when useful.

## Agent Brief

Use `references/agent-brief.md`.
