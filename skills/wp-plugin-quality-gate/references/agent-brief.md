# Agent Brief: Plugin Quality Gate

Use this before implementing or reviewing WordPress plugin code.

## Start By Naming The Contract

- bootstrap responsibilities
- owned data
- storage choice
- write permissions
- public surfaces
- hook contracts
- retention/uninstall policy
- verification plan

## Rules

- Keep the main plugin file boring.
- Put behavior behind namespaced or prefixed boundaries.
- Treat activation, deactivation, and uninstall as separate lifecycle contracts.
- Never delete durable user data on deactivation.
- Check capability and intent on write paths.
- Validate input shape.
- Sanitize before storage when needed.
- Escape late for output context.
- Use schemas and permission callbacks for REST.
- Use `block.json` and asset metadata for blocks.

## Done Means

- Syntax and smoke checks pass.
- Plugin lifecycle paths behave intentionally.
- Security boundaries are explicit.
- The feature can coexist with other WordPress plugins.
- Human review items are named: product intent, threat model, retention, accessibility, performance, compatibility, release timing.
