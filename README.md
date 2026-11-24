# laravel-starter-template

A Laravel 13 starter template with one front door, one gate list, and a checked
environment contract. Built so that after the first afternoon nobody has to think
about the toolchain again.

## Snel starten

1. Clone de repository in je Herd-map (`~/Herd` of `C:\Users\<jij>\Herd`).
2. Draai in die map één keer:

   ```bash
   composer run setup
   ```

3. Open de URL die erbij staat (`https://<map>.test`), of klik op de site in de
   Herd-app.

Klaar. Inloggen kan met `test@example.com` / `password`.
Geen Herd? Draai `php artisan serve` en open `http://localhost:8000`.

Alleen de site toevoegen in de Herd-app is niet genoeg: zonder
`composer run setup` zijn er geen `.env`, database en CSS, en krijg je een
foutpagina.

| Wil je…                    | Draai                                |
| -------------------------- | ------------------------------------ |
| Live reload tijdens stylen | `composer run dev`                   |
| De tests draaien           | `composer test`                      |
| Na een `git pull`          | niets, de git hooks werken alles bij |
| Er ziet iets raar uit      | `composer run refresh`               |

## Getting started in detail

Everything works with the plain Laravel commands (`composer`, `php artisan`,
`npm`), on macOS, Linux and Windows. The `make` targets run exactly the same
thing and are optional.

### First time

```bash
git clone <this repository>
cd <folder>
composer run setup        # or: make install
```

That one command installs the PHP and frontend dependencies, creates `.env` with
an application key, lets Herd serve the folder, migrates and seeds the SQLite
database, builds the CSS and JavaScript, and arms the git hooks. It ends by
printing the URL to open. Running it again is safe.

### Opening the site

**With Laravel Herd** (macOS or Windows), clone the repository anywhere under
Herd's folder (`~/Herd` or `C:\Users\<you>\Herd`, at any depth). `composer run setup`
links it, so the site is at `https://<folder>.test` straight away and stays up.
There is nothing to start and nothing to keep running. The styling is there
too, because Herd serves the built assets.

**Without Herd**, run `composer run dev` (or `make dev`) and open
`http://localhost:8000`.

`make status` shows the URL and what is running at any time.

### Everyday commands

| What                                    | Laravel                                        | make                          |
| --------------------------------------- | ---------------------------------------------- | ----------------------------- |
| Open the site (Herd)                    | nothing to run, open `https://<folder>.test`   |                               |
| Live reload while editing SCSS/JS/Blade | `composer run dev`                             | `make dev`                    |
| Run the tests                           | `composer test`                                | `make test`                   |
| Run one test                            | `php artisan test --filter=<name>`             | `make test-one filter=<name>` |
| After a `git pull` or a branch switch   | automatic; by hand `composer run refresh`      | `make update`                 |
| Run new migrations                      | `php artisan migrate`                          | `make migrate`                |
| Start the database over                 | `php artisan migrate:fresh --seed`             | `make fresh yes=1`            |
| Build the CSS and JavaScript            | `npm run build`                                | `make build`                  |
| Fix formatting                          | `vendor/bin/pint` and `npx prettier --write .` | `make format`                 |
| Every check CI runs, before pushing     |                                                | `make verify`                 |

**You never need `npm run dev` to see the styling.** It is only for live reload
while you edit: `composer run dev` runs Vite, the queue listener and the log tail
together (plus `php artisan serve` when Herd does not serve the folder). Stop it
with Ctrl-C and the pages fall back to the built assets.

**After a pull nothing needs remembering.** The `post-merge`, `post-checkout` and
`post-rewrite` git hooks run `composer run refresh` for you: they install changed
dependencies, run new migrations and rebuild the assets, in about a second when
nothing changed.

### When something looks wrong

| Symptom                                       | Fix                                                                                     |
| --------------------------------------------- | --------------------------------------------------------------------------------------- |
| The page has no styling                       | `composer run refresh`: rebuilds, and removes the hot file a crashed Vite leaves behind |
| `https://<folder>.test` says "Site not found" | `composer run setup`, or `herd link --secure` in the folder                             |
| An error about a missing table or column      | `php artisan migrate`                                                                   |
| Mails or links point at the wrong URL         | `composer run setup` sets `APP_URL` to the Herd URL                                     |

### Herd in more detail

Herd serves a folder when it is linked, or when it sits _directly_ inside a parked
directory. `~/Herd/my-app` is served; `~/Herd/development/my-app` is not until it
is linked, and setup (or `make herd`) does that with `herd link --secure`.
Setup does not link over a site name another folder already uses. In that case it
says which folder, and you pick a different name with
`herd link --secure <other-name>`.

Run one `composer run dev` per project. A second would fail on Vite's port and, on
its way out, switch off live reload for the first, so it refuses and says
which process holds the port. `make stop` ends a session's Vite, queue listener,
log tail and `artisan serve` for this folder only.

## Where you work

**Nobody commits to `main`.** `main` is always deployable; `develop` is where work
is integrated; a feature branch is cut from `develop` and merged back into it.

```bash
git switch develop && git pull
git switch -c feature/what-you-are-doing
# ... work ...
make verify          # about seven seconds; the pre-push hook runs it too
git push -u origin feature/what-you-are-doing
```

The full model, including hotfixes and how two people share one branch, is in
[docs/branching.md](docs/branching.md).

## Requirements

| Tool     | Version | Notes                                                      |
| -------- | ------- | ---------------------------------------------------------- |
| PHP      | 8.4+    | Laravel Herd, or any PHP with the extensions Laravel needs |
| Composer | 2.x     |                                                            |
| Node     | 24      | The version is in [.nvmrc](.nvmrc)                         |
| npm      | 11+     |                                                            |
| make     | 3.81+   | Optional. macOS ships it; on Windows see below             |

**Windows.** The Laravel commands above work natively, with Herd for Windows or
any PHP 8.4. Only `make` needs WSL2 (`wsl --install`, then clone inside it).
Without make, the pre-push hook says that `make verify` did not run and lets the
push through. CI runs the same checks either way.

Git Bash with `choco install make` does not work, and it fails in a way worth
knowing about: the native Windows make spawns `cmd.exe` for every recipe line and
silently ignores a POSIX shell it cannot resolve, so `vendor/bin/pint` comes back
as `'vendor' is not recognized as an internal or external command`. That reads
like a missing dependency but is really the wrong interpreter. This was measured
on a `windows-latest` runner, not assumed.

## The seeded account

Setup seeds one known local account, and `php artisan migrate:fresh --seed` (or
`make fresh yes=1`) recreates it:

```
email:    test@example.com
password: password
```

Log in with them at `/login`; the account's email address is already verified.

These credentials are written down on purpose. A shared, obviously-local account
is safer than five people each inventing one, and one of those reaching
production. It exists only in seed data and only in your local database.

## Authentication

Registration, login, logout, password reset, email verification, password
confirmation and a profile page (update details, change password, delete the
account) work straight after `composer run setup`. Functionally it is what
`php artisan breeze:install blade` gives you — the same route names, URIs,
middleware and behaviour — written in this template's own Blade components,
SCSS and vanilla JavaScript, with no Breeze, Tailwind or Alpine and no extra
dependency.

| Where                                     | What                                         |
| ----------------------------------------- | -------------------------------------------- |
| `routes/auth.php`                         | Every auth route, named as Breeze names them |
| `app/Http/Controllers/Auth/`              | One controller per flow                      |
| `app/Http/Requests/Auth/LoginRequest.php` | Login, rate-limited to five attempts         |
| `resources/views/auth/`, `profile/`       | The pages, on the guest and app layouts      |
| `lang/{en,nl}/*.php`, `lang/{en,nl}.json` | Every message, including the mails, in both  |

### Turning on email verification

Off by default, as in Breeze. In `app/Models/User.php`, remove the `//` before
`implements` on the class line:

```php
class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
```

`make format` then turns the class name into an import. From that moment a new
account is mailed a verification link, `/dashboard` (middleware `verified`)
stays closed until it is followed, and the profile page offers to re-send it.

### Where the mails go locally

`.env.example` sets `MAIL_MAILER=log`, so nothing is sent: the password reset
and verification mails are written to `laravel.log` in `storage/logs/`. Find the link
with:

```bash
grep -o 'https\?://[^ )"<]*reset-password[^ )"<]*' storage/logs/laravel.log | tail -1
grep -o 'https\?://[^ )"<]*verify-email[^ )"<]*' storage/logs/laravel.log | tail -1
```

With Herd Pro, set `MAIL_MAILER=smtp` instead — `MAIL_HOST=127.0.0.1` and
`MAIL_PORT=2525` already point at Herd's mail service — and the mails appear,
rendered and clickable, under **Mail** in Herd.

## Layout

| Path                | What lives there                                               |
| ------------------- | -------------------------------------------------------------- |
| `app/`              | Models, controllers, form requests, policies, resources        |
| `resources/views/`  | Blade: a component layout, partials and anonymous components   |
| `resources/scss/`   | The design system: tokens, base, layout, components, utilities |
| `resources/css/`    | Plain CSS, for whoever would rather not write SCSS             |
| `database/`         | Migrations, factories with states, seeders                     |
| `tests/`            | Pest — Unit, Feature and Arch suites                           |
| `scripts/`          | The check harness and the runtime helpers                      |
| `docs/toolchain.md` | Why the toolchain is shaped this way, and what it does not do  |
| `docs/erd.md`       | The data model as a Mermaid diagram, generated by `make erd`   |

## What is in the box

No demo. `/` renders `resources/views/home.blade.php`: the navbar, an empty
content area and the footer. It exists so the layout, the design system and the
Vite manifest are exercised by a real request. The content is yours.

Every component in `resources/views/components/` opens with a usage example,
so you can copy it straight into a page.

The conventions are carried by the structure rather than by example code:
`app/Http/Requests`, `app/Http/Resources` and `app/Policies` are present and
empty, the Blade components and SCSS layers are ready to use, and `make arch`
enforces the naming rules on the first class you add to any of them.

## Building a page

1. Add a route in `routes/web.php`, for example
   `Route::view('/about', 'about')->name('about');`.
2. Create the view `about.blade.php` in `resources/views/` and wrap it in the
   page shell:

   ```blade
   <x-layouts.app :title="__('About us')">
       <h1>{{ __('About us') }}</h1>
       <x-button href="{{ route('home') }}">{{ __('Back home') }}</x-button>
   </x-layouts.app>
   ```

3. Pick components from `resources/views/components/`. The top of each file
   shows how to use it and which props it takes.
4. Need extra styling? Put it in `resources/css/app.css` (plain CSS), or add a
   `resources/scss/components/_<name>.scss` and `@forward` it in that folder's
   `_index.scss`. Use the tokens (`var(--spacing-md)`, `var(--color-text-primary)`)
   instead of raw values.

Write every visible text in English inside `__('…')`.

## Styling

The design system is the **TLE2 Styleguide** in Figma, implemented one to one:
the Figma variables are CSS custom properties with the same names
(`--color-text-primary`, `--spacing-md`, `--radius-sm`), the text styles are the
`text()` mixin and the `.text-*` classes, and every Figma component is a Blade
component (`<x-button variant="accent">`) whose props are the Figma properties.

No Tailwind. SCSS, BEM class names, and every layer of the system in its own CSS
cascade layer — `tokens, base, layout, components, utilities, app` — so a later
layer always wins without a fight over specificity.

**SCSS or CSS, both work.** What reaches the browser is plain CSS. Write SCSS in
`resources/scss/`, or plain CSS in `resources/css/app.css`: the same tokens and
classes, native CSS nesting, and the `app` layer, which always beats the design
system. Add a token before using a raw value: a hex code in a component is the
thing the token files exist to prevent. The full conventions are in
[.claude/rules/scss.md](.claude/rules/scss.md).

## Licence

**All rights reserved.** This is private work, not open source. There is no
permission to copy, use, modify or redistribute it, and the repository being
technically reachable does not grant one. See [LICENSE](LICENSE).

The Laravel skeleton this is built on stays MIT (© Taylor Otwell) — that part
cannot be relicensed and is not claimed. The LICENSE file says which files those
are.

If you want to use this, ask.

## Documentation

- [docs/branching.md](docs/branching.md) — `main`, `develop` and feature branches:
  what goes where, and why nobody commits to `main`.
- [docs/erd.md](docs/erd.md) — the data model as a Mermaid diagram that GitHub
  renders. `make erd` redraws it after a migration; write your notes around it.
- [docs/toolchain.md](docs/toolchain.md) — the gates, the decisions behind them,
  and the things this template deliberately does not set up.
- [AGENTS.md](AGENTS.md) — the map for coding agents.
