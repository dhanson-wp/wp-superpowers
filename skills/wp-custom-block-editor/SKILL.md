---
name: wp-custom-block-editor
description: "Use when building purpose-specific Gutenberg editors outside the standard post editor: frontend composers, modal capture editors, profile editors, onboarding editors, card composers, and other custom block editing surfaces."
compatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node. Requires Gutenberg/block-editor package verification in the target project."
---

# WP Custom Block Editor

## When to use

Use this add-on after the base block-development skills when a WordPress project needs a custom editor surface that still saves valid block grammar, such as:

- a frontend composer or capture modal
- a profile intro/card editor
- a lightweight onboarding editor
- an admin page editor that is not the normal post editor
- a constrained editor with curated blocks, product chrome, custom persistence, or no Inspector

If the task is ordinary block development, use the default `wp-block-development` skill first. This add-on is the custom-editor composition layer on top.

## Inputs required

- Target project root and WordPress/Gutenberg package versions.
- Editor location: admin, frontend, modal, drawer, inline surface.
- Storage target: post content, CPT, user meta, option, custom table, REST endpoint.
- Allowed blocks and whether media is enabled.
- Permission/capability model for saving.
- Styling source: active theme styles, product shell, custom editor styles.
- Need for autosave, revisions, validation, preview, or multiple instances.

## Procedure

1. Inspect the target project before coding.
2. Check whether a default WordPress skill applies first:
   - `wordpress-router`
   - `wp-project-triage`
   - `wp-block-development`
   - `wp-rest-api`
   - `wp-playground`
3. Read `references/guide.md`.
4. Use `BlockEditorProvider` for arbitrary block grammar editors.
5. Use `EditorProvider` only when truly editing a WordPress entity through core-data.
6. Start from the Light Composer default unless the workflow clearly needs a heavier editor:
   - native toolbar
   - no Inspector by default
   - no visible root appender by default
   - slash insertion as primary insertion
   - product chrome for document actions
7. Store content with `serialize()` and hydrate with `parse()`.
8. Configure media, nonce middleware, editor settings, and theme styles explicitly.
9. Keep block-aware UI inside the provider tree.

## Verification

- Editor loads without console errors.
- Blocks insert, edit, move, delete, save, and reload.
- `parse()`/`serialize()` round-trip without block recovery.
- Allowed blocks are enforced.
- Slash insertion works.
- Media works or is intentionally disabled.
- Undo/redo works when enabled.
- Multiple instances do not leak state.
- Save permissions are enforced.
- Frontend rendering does not leak wp-admin chrome.
- Mobile/modal widths do not break toolbar or canvas.

## Failure modes / debugging

- Fake toolbar controls that are not connected to the block editor store.
- `core/list` allowed without `core/list-item`.
- Missing media upload filter or API nonce middleware.
- Rehydration effects that reset block state every render.
- Host CSS leaking into editor iframe compatibility paths.
- Using `EditorProvider` when the editor is not a core-data entity editor.

## Escalation

If package behavior differs from this guide, inspect the target project's installed Gutenberg packages and local WordPress version. Source wins.
