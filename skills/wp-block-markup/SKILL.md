---
name: wp-block-markup
description: "Use when generating or validating Gutenberg block markup for posts, pages, block patterns, templates, template parts, and agent-generated WordPress content. Integrates with existing block-markup MCP or validator tools when available."
compatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node. External block-markup validators or MCP tools may be project-specific."
---

# WP Block Markup

## When to use

Use this add-on when generating or reviewing:

- post/page content as block markup
- block patterns
- block theme templates or template parts
- agent-generated WordPress content
- content that will be validated by an external block-markup MCP or validator

If the project already has a block-markup MCP or validator, use it. This add-on supplies the WordPress editing/verification checklist around that tool. Do not copy or recreate the tool.

## Inputs required

- Target context: post content, pattern, template, template part, synced pattern, or seed content.
- Available blocks in the target project.
- Whether custom blocks are registered.
- Available validator: WordPress, MCP, CLI, browser/editor check.

## Procedure

1. Inspect the target project's registered blocks when possible.
2. Read `references/guide.md`.
3. Prefer conservative core block markup.
4. Keep block comments, attributes, and nesting valid.
5. Use external validators/tools when available.
6. Open in WordPress when possible.
7. Fix block recovery warnings before shipping.

## Verification

- WordPress parses the content as blocks.
- The editor opens without block recovery warnings.
- Frontend rendering matches intent.
- Custom blocks used by the markup are registered.
- Template and pattern files use the correct context.

## Failure modes / debugging

- HTML that looks right but is not block markup.
- Invalid JSON in block comments.
- Using unavailable custom blocks.
- Over-nesting layout blocks.
- Generating content that cannot be edited safely.

## Escalation

If validation requires a proprietary or project-specific MCP, document the command/tool used without vendoring or copying it.
