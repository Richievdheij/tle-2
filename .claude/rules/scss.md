---
paths:
  - resources/scss/**
  - resources/css/**
  - resources/js/**
description: Conventions for the design system — tokens, cascade layers, BEM, plain CSS and frontend JavaScript.
---

# Styling

Dart Sass through `sass-embedded`. No Tailwind, and no utility framework is to be
added — the tokens are the shared vocabulary that would otherwise be.

The design system is the **TLE2 Styleguide** in Figma (file
`ZqeL3mWlzYdSCqkm87thcF`): its variables are the tokens, its components are the
Blade components. When the two disagree, Figma is right and the code is the bug.

## Layers

`main.scss` is the only entry point Vite compiles. It declares the CSS cascade
layers once, in order, and loads each directory into its own layer:

```
tokens      custom properties only (tokens/)
base        element defaults: reset, body text, headings (base/)
layout      the page frame: container, grid, navbar, footer (layout/)
components  one block per Figma component (components/)
utilities   .sr-only and the .text-* classes (utilities/)
app         plain CSS from resources/css — always wins
```

A later layer beats an earlier one **regardless of specificity**. Two rules follow:

- **Never restyle another block's root.** `layout/` sits below `components/`, so
  `.navbar .button { … }` loses to `.button { … }`. Wrap the component in an
  element of your own block (`.navbar__wide`) or give the component a prop.
- **Never `!important`.** A utility already beats a component, and `app` already
  beats everything.

`abstracts/` emits **no CSS**: breakpoints, the `text()` mixin, `focus-ring`,
`transition`, `button-reset`. Every module may `@use '../abstracts' as *;`.
Include `button-reset` **before** `text()` — it resets `font`.

## Tokens

CSS custom properties on `:root`, in `tokens/`. The names are the Figma
variables' Web code syntax (`--color-text-primary`, `--spacing-md`,
`--radius-sm`), so a value from Dev Mode is already a valid name.

- `--toc-*` are primitives. Components read only the semantic `--color-*`.
- Text styles are five properties each (`--text-heading-1-size`, `-line-height`,
  `-weight`, `-tracking`, `-case`). Apply one whole with `@include text('heading-1')`
  or the `.text-heading-1` class.
- **Add a token before using a raw value.** A hex code, a px gap or a font stack
  written inline is what `tokens/` exists to prevent. A one-off dimension a
  component needs goes in a block-local custom property at the top of the block,
  named after it (`--site-footer-brand-width`).
- There is one colour mode, Light. Figma defines no dark scheme, so there is none.

The one place a Sass variable is correct is `$breakpoints`: a media query cannot
read a custom property. `@include from('tablet')` / `until('tablet')`; the widths
are tablet 48rem (768), desktop 80rem (1280), wide 120rem (1920).

Use `map.get` from `sass:map`, never the global `map-get`.

## BEM

`.block`, `.block__element`, `.block--modifier`; a state is `.is-*` or an ARIA
attribute. A modifier never appears without its block; an element never styles
anything outside its block. Block names describe the role, never the appearance.

Keep comments short: one line at the top of a file if the name does not say it
all, and one line beside code that would otherwise look wrong. A Blade component
opens with one line on what it is, a usage example and a `Props:` line.

## Plain CSS

`resources/css/app.css` is for teammates who do not write Sass. It is compiled
into the same stylesheet, in the `app` layer: it can use every token and every
class, native CSS nesting works, and its rules always win. No Sass syntax there.

## Interaction

Hover transitions ease out over the duration the Figma prototype uses (tokens in
`tokens/_motion.scss`). The focus ring is keyboard-only (`:focus-visible`), never
a state in the design; on navy use `@include focus-ring('inverse')`.

## JavaScript

`resources/js/app.js` is progressive enhancement, and is meant to stay small. No
framework. A component that needs script gets `resources/js/components/<name>.js`
exporting `initialise<Name>()`, called from app.js. Query by `data-` attribute
rather than by CSS class. Leave the markup usable without JavaScript.

`VITE_PORT` is declared in both env templates and Vite runs with `strictPort`, so
a busy port fails loudly instead of moving to 5174.
