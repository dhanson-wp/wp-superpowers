# WordPress Plugin Quality Gate

Status: `verified`

Use this before building, reviewing, or shipping a WordPress plugin feature.

## Problem

WordPress plugins fail when they skip the boring contracts: discovery, bootstrap boundaries, activation/deactivation/uninstall behavior, permissions, sanitization, escaping, storage choice, REST schema, accessibility, and release readiness.

## Use When

- Starting a plugin.
- Reviewing a plugin.
- Adding write paths, REST endpoints, blocks, admin screens, cron, or external services.
- Preparing release artifacts.

## Implementation Shape

Answer these before coding:

- What does WordPress discover: folder, main file, header, guards, constants, autoload, bootstrap?
- What data does the plugin own?
- Where does that data live?
- What is the retention and uninstall policy?
- Which actors can write?
- What capability proves that?
- What verifies intent?
- What input shape is accepted?
- What gets sanitized before storage?
- What output context requires escaping?
- Which APIs fit the data shape with the least custom machinery?
- Which hooks are public contracts?
- Which REST or MCP surfaces need schemas, permissions, stable handles, next actions, and recovery guidance?

## Verification Gate

- PHP syntax checks pass.
- Plugin activates.
- Plugin deactivates without deleting durable data.
- Uninstall behavior matches policy.
- Write paths check capabilities and intent.
- Inputs validate and sanitize.
- Output escapes late for context.
- REST endpoints have schemas and permission callbacks.
- Blocks use `block.json` and generated asset metadata.
- Cron unschedules correctly.
- Admin and frontend states are accessible.
- Release artifacts include source/build files needed for review.

## Known Failure Modes

- Fat main plugin file.
- Unprefixed global functions.
- Deleting durable user data on deactivation.
- Treating nonce checks as authorization.
- Sanitizing and escaping as if they are the same operation.
- Choosing custom tables before proving query/relational need.
- Shipping without activation/deactivation/uninstall smoke checks.

## Agent Brief

Use `references/agent-brief.md`.
