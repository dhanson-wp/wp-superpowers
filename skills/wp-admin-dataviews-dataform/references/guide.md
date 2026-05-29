# DataViews and DataForm

Status: `verified`

Use DataViews for WordPress-native data browsing and DataForm for WordPress-native object editing inside admin screens.

## Problem

Plugin admin screens often drift into generic React dashboards or custom table clones. DataViews and DataForm let a plugin build modern admin workflows while preserving WordPress UI grammar.

## Use When

- You need search, sorting, filtering, pagination, field visibility, row actions, table/grid/list layouts, or item editing.
- You need a settings screen that edits one option object or entity record.
- You want the screen to feel like wp-admin, not a SaaS dashboard.

## Avoid When

- A core WordPress screen already solves the workflow.
- The task needs only a small static settings form.
- You have not defined the server-side data contract, schema, sanitization, and permissions.

## Implementation Shape

For admin screens:

- PHP registers the admin page with `add_menu_page`, `add_submenu_page`, or a focused helper.
- PHP renders the normal wp-admin heading and one React root.
- Assets enqueue only for the matching `$hook_suffix`.
- JS imports DataViews/DataForm from `@wordpress/dataviews/wp`.
- The plugin owns data fetching, mutation, permissions, and REST schemas.
- DataViews owns view state presentation, not data storage.

For DataForm settings:

- PHP registers the option with `register_setting()`.
- `show_in_rest` includes a specific schema.
- PHP sanitizes every field.
- JS reads from `/wp/v2/settings` or core-data.
- `DataForm` receives stable `data`, `fields`, `form`, and `onChange`.

## Verification Gate

- Admin page appears in the intended menu.
- Assets load only on that page.
- DataViews styles and components styles are present.
- Search, sorting, filtering, pagination, field visibility, layout switching, row actions, and item details work when applicable.
- DataForm fields keep focus while typing.
- Save round-trips through REST and server sanitization.
- The screen grows with page content by default; only constrained drawers/modals scroll internally.
- Console is clean.
- The result feels like wp-admin.

## Known Failure Modes

- Importing the wrong package entry instead of `@wordpress/dataviews/wp`.
- Skipping DataViews styles and then compensating with custom CSS.
- Recreating `fields` and `form` objects on every render, causing focus loss.
- Treating DataForm as validation instead of server-side schema and sanitization.
- Building a custom dashboard shell around WordPress components.
- Making main admin DataViews internally scroll when the page should grow.

## Agent Brief

Use `references/agent-brief.md`.
