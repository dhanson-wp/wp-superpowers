# Contributing

WP Superpowers accepts add-on skills that improve how agents use established WordPress development knowledge.

## A Good Contribution

- Names the WordPress problem clearly.
- Links to official source material when possible.
- Explains when to use the guide and when not to use it.
- Includes implementation shape, verification gate, and known failure modes.
- Avoids project-specific details and third-party course branding.
- Works for both humans and agents.

## Promotion Path

1. `observed` - source/docs reviewed.
2. `practiced` - rebuilt in a small example.
3. `verified` - tested in Playground, browser, or a real WordPress environment.
4. `candidate` - ready for product evaluation.
5. `adopted` - used in a real product.

## Naming

Use neutral WordPress development names:

- Good: `Plugin Quality Gate`, `Custom Block Editor`, `DataViews Admin Screens`.
- Avoid: course names, product names, agent-vendor names, or novelty names as canonical skill names.

## File Shape

Every superpower should follow the WordPress Agent Skills shape:

```text
skills/<skill-name>/
├── SKILL.md
├── references/
│   └── guide.md
└── scripts/
    └── optional-helper.mjs
```

Every skill must include at least one scenario under `eval/scenarios/`.
