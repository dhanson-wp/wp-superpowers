# Architecture

WP Superpowers is an add-on skill pack.

The default WordPress skills teach the base domain. WP Superpowers adds the next layer: the product-shaped decisions, quality gates, and verification loops that become important after the basics are already loaded.

It provides the portable reasoning layer that tells a human or agent:

- which default WordPress skill to load first
- which WP Superpowers add-on applies next
- which official/source material wins
- which external tool to use when available
- what verification gate proves the work
- what failure modes to avoid

## Layers

1. WordPress and Gutenberg source are the authority.
2. Project code and installed versions define the local truth.
3. Established WordPress agent skills provide the default broad domain guidance.
4. Existing specialized tools do the jobs they already do well.
5. WP Superpowers provides add-on skill bundles for the extra workflows learned in practice.

## Skills

Skills in this repo are enhancements:

- `SKILL.md` stays short and procedural.
- Deeper guidance lives one hop away in `references/`.
- Eval scenarios describe expected agent behavior.
- External tools are referenced, not copied.
- Base WordPress skills are composed with, not duplicated.

They should not hard-require a particular agent framework unless the file is explicitly inside that framework's adapter folder.

## External Tools

If an external tool already exists, reference it instead of copying it.

Examples:

- Use an available block-markup MCP or validator for block markup execution.
- Use WordPress Playground for disposable runtime verification.
- Use browser automation for UI and console checks.

The add-on skill remains the source of intent; the tool performs the check.
