# Agent Brief: Custom Block Editor

Use this when building a purpose-specific Gutenberg editor outside the normal post editor.

## Default

Build a Light Composer:

- `BlockEditorProvider`
- native block toolbar
- no Inspector unless requested
- no visible root plus appender unless requested
- slash insertion as primary insertion
- product chrome for save, undo, redo, history, close, metadata, publish
- store content as serialized block markup

## Before Coding

Identify:

- location: admin page, frontend, modal, drawer, inline editor
- storage target: post content, CPT, user meta, option, custom table, REST endpoint
- allowed blocks
- media behavior
- permissions
- theme/style source
- autosave/revisions/error behavior

Inspect the target project and installed Gutenberg/WordPress package versions before implementation.

## Implementation Rules

- Use `BlockEditorProvider` for arbitrary block grammar.
- Use `EditorProvider` only for true WordPress entity editing through core-data.
- Use `parse()` and `serialize()` from `@wordpress/blocks`.
- Include `core/list-item` whenever `core/list` is allowed.
- Register `editor.MediaUpload` and configure `apiFetch` nonce middleware when media uploads are expected.
- Pass theme-derived editor settings from PHP into the editor.
- Keep block-aware toolbar or inspector UI inside the provider tree.
- Use native WordPress components before bespoke controls.

## Done Means

- Browser console is clean.
- Blocks insert/edit/move/delete.
- Save and reload preserve valid block markup.
- Allowed blocks are enforced.
- Slash insertion works.
- Media works or is intentionally disabled.
- Undo/redo works.
- Permissions are enforced.
- UI does not feel like a generic React app dropped into WordPress.
