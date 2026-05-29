# Agent Brief: DataViews and DataForm

Use this for modern WordPress plugin admin screens.

## Default

- Preserve wp-admin shell.
- Use PHP to register the admin page.
- Render one React root inside a normal WordPress admin page.
- Import DataViews/DataForm from `@wordpress/dataviews/wp`.
- Keep data ownership, permissions, REST schema, and sanitization server-led.

## DataViews Must Cover

- search
- sorting
- filtering
- pagination
- visible fields
- row actions
- item details/editing when the workflow needs it
- table/list/grid layout where appropriate

## DataForm Must Cover

- server-registered option/entity
- REST schema
- server sanitization
- stable `fields` and `form` references
- save status and errors
- front-end verification if settings affect front-end output

## Done Means

- Styles are loaded.
- Console is clean.
- The screen feels like wp-admin.
- Main admin pages grow naturally; drawers and modals may scroll internally.
- Interaction coverage is complete for the workflow.
