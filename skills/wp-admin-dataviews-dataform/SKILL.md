---
name: wp-admin-dataviews-dataform
description: "Use when building WordPress-native wp-admin data screens with DataViews and object/settings editing forms with DataForm, including search, filtering, sorting, pagination, visible fields, row actions, item details, and settings save flows."
compatibility: "Targets WordPress 6.9+ (PHP 7.2.24+). Filesystem-based agent with bash + node. DataViews/DataForm package APIs must be checked in the target project."
---

# WP Admin DataViews DataForm

## When to use

Use this add-on after the base WordPress admin/plugin skills when a DataViews/DataForm screen needs to feel complete, native, and product-ready.

Use it for admin screens that need:

- DataViews list/table/grid browsing
- DataForm object or settings editing
- REST-backed admin workflows
- wp-admin-native layout, density, and interaction behavior

If the task is generic plugin architecture, use the default `wp-plugin-development` skill first. This add-on starts at the admin UI quality layer: full interaction coverage, server-led contracts, and wp-admin visual behavior.

## Inputs required

- Target plugin/theme path and admin page hook.
- Data source and mutation path.
- REST schema, capability, and sanitization plan.
- Required interactions: search, sorting, filters, pagination, fields, row actions, details/edit.
- Whether settings affect frontend output.

## Procedure

1. Inspect the target project and existing admin tooling.
2. Route through default skills when available:
   - `wordpress-router`
   - `wp-project-triage`
   - `wp-plugin-development`
   - `wp-rest-api`
3. Read `references/guide.md`.
4. Register a normal wp-admin page in PHP.
5. Render one React root inside the WordPress admin shell.
6. Enqueue scripts/styles only on the target `$hook_suffix`.
7. Import DataViews/DataForm from `@wordpress/dataviews/wp`.
8. Keep data ownership, REST schema, permission callbacks, and sanitization server-led.
9. Use DataViews/DataForm for the interaction model; avoid custom dashboard chrome.
10. Apply the add-on gate: complete interaction coverage, page-growing layout, stable form configuration, server-led schema/sanitization, and wp-admin feel.

## Verification

- Admin page appears in the intended menu.
- Assets load only on the target page.
- Package and component styles are present.
- Search, sorting, filtering, pagination, visible fields, layout switching, row actions, and item details work when required.
- DataForm fields keep focus while typing.
- Saves round-trip through REST and server sanitization.
- Main admin screens grow with page content; constrained drawers/modals may scroll internally.
- Console is clean.
- The screen feels like wp-admin.

## Failure modes / debugging

- Importing the wrong package entry instead of `@wordpress/dataviews/wp`.
- Skipping package styles and compensating with custom CSS.
- Treating DataForm as validation instead of server schema and sanitization.
- Recreating `fields` and `form` objects on every render.
- Building a generic React dashboard inside wp-admin.

## Escalation

If DataViews/DataForm APIs differ, inspect local Gutenberg package source and the target project's installed versions before continuing.
