# Custom Block Editor

Status: `verified`

Build purpose-specific Gutenberg editors for admin pages, frontend modals, profile editors, capture flows, onboarding, card composers, and other non-standard WordPress surfaces.

## Problem

The standard post editor is only one composition of Gutenberg packages. Products often need a smaller editor surface that still preserves real block grammar, native block behavior, and WordPress UI expectations.

## Use When

- A product needs block editing outside the normal post editor.
- Content should still save as valid block markup.
- The host app owns storage, permissions, metadata, validation, and product chrome.
- The editor should feel native without exposing the entire post-editor experience.

## Avoid When

- The normal post editor already fits the workflow.
- The surface only needs plain text or a classic textarea.
- You cannot verify block validity, media behavior, and persistence.
- You are tempted to rebuild Gutenberg toolbar behavior with fake buttons.

## Core Model

Use `BlockEditorProvider` for arbitrary block grammar editors.

```jsx
<BlockEditorProvider
	value={ blocks }
	onInput={ setBlocks }
	onChange={ persistBlocks }
	settings={ settings }
>
	<EditorSurface />
</BlockEditorProvider>
```

The host app owns:

- storage
- permissions
- product chrome
- metadata
- validation
- design presets

Gutenberg owns:

- block editing context
- selection
- toolbar mechanics
- block rendering
- rich text behavior
- parse/serialize grammar

## Default Surface

Start from a Light Composer unless the workflow needs a heavier editor:

- no Inspector by default
- no visible root plus appender by default
- slash insertion as the primary insertion path
- native block toolbar first
- product chrome for save, undo, redo, history, close, metadata, and publish
- narrow allowed block set
- theme styles as the baseline

Recommended starter blocks:

- `core/paragraph`
- `core/heading`
- `core/list`
- `core/list-item`
- `core/image`
- `core/quote`
- `core/separator`
- `core/code`

Include `core/list-item` when allowing `core/list`; it is required for real list editing even if it should not appear as a top-level product choice.

## Implementation Shape

- Register core blocks with `registerCoreBlocks()`.
- Use `parse()` and `serialize()` from `@wordpress/blocks`.
- Pass a curated subset of `get_block_editor_settings()` from PHP so theme presets, styles, layout settings, and block supports are available.
- Configure `apiFetch` nonce middleware at app startup.
- Register `editor.MediaUpload` with `@wordpress/media-utils` and enqueue the media frame when uploads/library are expected.
- Use `BlockTools`, `WritingFlow`, and `BlockList` for lightweight non-iframe composition.
- Use `BlockCanvas` when the iframe boundary and full canvas behavior are useful.
- Keep block-aware UI inside the provider tree.
- Use REST endpoints for real persistence.

## Verification Gate

- Editor loads without console errors.
- Blocks insert, edit, move, delete, save, and reload.
- `parse()`/`serialize()` round-trip without block recovery.
- Allowed blocks are enforced.
- Slash insertion works.
- Native image upload/library/URL behavior works when media is enabled.
- Quote shortcut and citation behavior are checked if `core/quote` is allowed.
- Undo/redo works.
- Multiple editor instances do not leak state.
- Permissions are enforced on save.
- Frontend rendering does not leak wp-admin chrome.
- Mobile/modal widths do not break toolbar or canvas.

## Known Failure Modes

- Treating `EditorProvider` as the default for non-entity editors.
- Skipping `core/list-item` and breaking list editing.
- Passing raw inserter icon objects directly into `Button`.
- Rehydrating editor state on every render because effects depend on unstable history objects.
- Letting host CSS with `.editor-styles-wrapper` or `.wp-block*` selectors leak into iframe compatibility handling.
- Showing toolbar controls that are visual-only and not connected to the block editor store.

## Agent Brief

Use `references/agent-brief.md`.
