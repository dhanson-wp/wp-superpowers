# Block Markup

Status: `candidate`

Use valid Gutenberg block markup as the portable content format for posts, block patterns, templates, examples, and agent-generated WordPress content.

This guide is a reasoning and verification guide. It should integrate with existing block-markup validators and MCP tools when they are available. Do not copy or reimplement another project's MCP server or proprietary workflow here.

## Problem

Agents can generate visually plausible WordPress content that is not valid block markup. Invalid markup causes block recovery, broken templates, or content that cannot be safely edited in the block editor.

## Use When

- Creating posts or pages programmatically.
- Generating block pattern examples.
- Creating template parts or block theme files.
- Asking an agent to produce WordPress content.
- Using an existing block-markup validator or MCP tool.

## Implementation Shape

- Prefer core blocks unless a custom block is required.
- Use real block comments and attributes.
- Keep nesting valid.
- Preserve user-editability in the block editor.
- Validate against WordPress or an available block-markup tool where possible.

## Verification Gate

- Markup parses as blocks.
- Opening in the block editor does not trigger recovery.
- Frontend rendering matches intent.
- Custom blocks are registered before content uses them.
- Template and pattern files use the correct context.

## Known Failure Modes

- HTML that looks right but is not block markup.
- Invalid JSON in block comments.
- Using unavailable custom blocks.
- Over-nesting groups, columns, and covers to fake layout.
- Generating content that cannot be edited safely.

## Tool Integration

When a project already depends on a block-markup MCP or validator, use it as the execution tool and use this guide as the agent-facing checklist:

1. Generate conservative core-block markup.
2. Validate with the available tool.
3. Open in WordPress when possible.
4. Fix recovery warnings before shipping.

The public repo should document how to call external tools, not vendor or clone them.

## Agent Brief

Use `references/agent-brief.md`.
