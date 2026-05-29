# Agent Brief: Block Markup

Use this when generating WordPress content, block patterns, or templates.

If the project has a block-markup MCP or validator available, use that tool. Do not copy or recreate it.

## Rules

- Generate valid Gutenberg block markup.
- Prefer core blocks.
- Keep attributes valid JSON.
- Keep nesting legal.
- Avoid layout hacks that make editing painful.
- Verify with the available validator and in WordPress when possible.

## Done Means

- WordPress parses the content as blocks.
- The editor opens without recovery warnings.
- The frontend rendering matches the intent.
- Any custom block used by the markup is registered in the target project.
