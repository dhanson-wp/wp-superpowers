# Interactivity API

Status: `practiced`

Use the WordPress Interactivity API for server-rendered blocks that need accessible frontend behavior without turning the whole feature into a custom client app.

## Problem

Interactive WordPress blocks often become bespoke JavaScript islands. The Interactivity API provides a WordPress-native way to connect server-rendered markup, directive attributes, state, actions, and frontend updates.

## Use When

- A block needs frontend interaction.
- The initial markup should remain server-rendered.
- State and actions can be modeled through WordPress directives.
- The interaction should compose with block themes and normal WordPress rendering.

## Avoid When

- The feature is a full standalone application.
- The interaction cannot be represented cleanly with directive state/actions.
- You have not verified markup and behavior in Playground or a real theme.

## Implementation Shape

- Start from a small faithful example.
- Use `block.json`.
- Use server-rendered markup where possible.
- Put directive attributes in meaningful HTML.
- Keep state, actions, and callbacks scoped.
- Verify the frontend, not just the editor.
- Add one useful variation after the faithful rebuild works.

## Verification Gate

- Block registers and renders.
- Markup is meaningful before JavaScript behavior.
- Directives update the expected state.
- Actions work with keyboard and pointer input.
- No console errors.
- Behavior works after reload.
- The feature still fits the active theme.

## Known Failure Modes

- Building a generic React app instead of a WordPress interactive block.
- Hiding inaccessible state changes behind color or motion only.
- Skipping frontend verification.
- Letting practice examples grow into giant demos instead of small reusable proofs.

## Agent Brief

Use `references/agent-brief.md`.
