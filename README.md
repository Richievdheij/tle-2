# TLE2

Een website voor een (fictief) non-profit dat zee, stranden en oceanen schoon
wil krijgen. Op dit moment kun je het goede doel alleen steunen door fysiek mee
te helpen. Met deze website kan dat ook online: door te doneren, of door zelf
een cleanup-event te starten of aan te sluiten bij een bestaand event.

Het is een schoolproject (TLE2) in opdracht van **IO**.
De site draait op dummy data en gebruikt geen echt geld en geen echte betaalgegevens.

## Snel starten

1. Clone de repository in je Herd-map (`~/Herd` of `C:\Users\<jij>\Herd`):

   ```bash
   git clone https://github.com/Richievdheij/tle-2.git
   cd tle-2
   ```

2. Draai in die map één keer:

   ```bash
   composer run setup
   ```

3. Open de URL die aan het eind getoond wordt (meestal `https://tle-2.test`), of
   klik op de site in de Herd-app.

Klaar. Inloggen kan met `test@example.com` / `password`.
Geen Herd? Draai `composer run dev` en open `http://localhost:8000`.

`composer run setup` installeert de PHP- en frontend-dependencies, maakt `.env`
met een application key, laat Herd de map serveren, maakt de MySQL-database
`tle_2` aan, migreert en seedt hem, bouwt de CSS en JavaScript en zet de git
hooks aan. Je kunt het veilig opnieuw draaien.

Alleen de site toevoegen in de Herd-app is niet genoeg: zonder
`composer run setup` zijn er geen `.env`, database en CSS, en krijg je een
foutpagina.

## Benodigdheden

De database bekijk je in phpMyAdmin op <http://phpmyadmin.test> (user `root`,
geen wachtwoord). Heeft jouw MySQL wel een wachtwoord, zet het dan in
`DB_PASSWORD` in `.env`.

**Windows.** De `composer`- en `php artisan`-commando's werken gewoon, met Herd
voor Windows of een andere PHP 8.4. Alleen `make` heeft WSL2 nodig
(`wsl --install`, en clone daarbinnen). Zonder make meldt de pre-push hook dat
`make verify` niet gedraaid is en laat hij de push door; CI draait dezelfde
checks toch.

## Dagelijkse commando's

Alles werkt met de gewone Laravel-commando's (`composer`, `php artisan`, `npm`).
De `make`-targets doen precies hetzelfde en zijn optioneel.

| Wat                                 | Laravel                                         | make                          |
| ----------------------------------- | ----------------------------------------------- | ----------------------------- |
| De site openen (Herd)               | niets te draaien, open `https://tle-2.test`     | `make status` toont de URL    |
| Live reload tijdens SCSS/JS/Blade   | `composer run dev`                              | `make dev`                    |
| De tests draaien                    | `composer test`                                 | `make test`                   |
| Eén test draaien                    | `php artisan test --filter=<naam>`              | `make test-one filter=<naam>` |
| Na een `git pull` of andere branch  | automatisch; met de hand `composer run refresh` | `make update`                 |
| Nieuwe migrations draaien           | `php artisan migrate`                           | `make migrate`                |
| De database opnieuw opbouwen        | `php artisan migrate:fresh --seed`              | `make fresh yes=1`            |
| CSS en JavaScript bouwen            | `npm run build`                                 | `make build`                  |
| Opmaak herstellen                   | `vendor/bin/pint` en `npx prettier --write .`   | `make format`                 |
| Alle checks van CI, vóór het pushen |                                                 | `make verify`                 |
| Draaiende processen stoppen         |                                                 | `make stop`                   |

**Voor de styling heb je `npm run dev` nooit nodig.** Herd serveert de gebouwde
assets. `composer run dev` is alleen voor live reload: het draait Vite, de queue
listener en de log tail samen (plus `php artisan serve` als Herd de map niet
serveert). Stop het met Ctrl-C; de pagina's vallen dan terug op de gebouwde
assets. Draai per project maar één `composer run dev`.

**Na een pull hoef je niets te onthouden.** De git hooks `post-merge`,
`post-checkout` en `post-rewrite` draaien `composer run refresh`: nieuwe
dependencies, nieuwe migrations en opnieuw gebouwde assets, in ongeveer een
seconde als er niets veranderd is.

## Als er iets mis lijkt

| Wat je ziet                                   | Oplossing                                                                             |
| --------------------------------------------- | ------------------------------------------------------------------------------------- |
| De pagina heeft geen styling                  | `composer run refresh`: bouwt opnieuw en ruimt het hot file van een gecrashte Vite op |
| `https://tle-2.test` zegt "Site not found"    | `composer run setup`, of `herd link --secure` in de map                               |
| Een fout over een ontbrekende table of column | `php artisan migrate`                                                                 |
| Mails of links wijzen naar de verkeerde URL   | `composer run setup` zet `APP_URL` op de Herd-URL                                     |

## De site openen

**Met Laravel Herd** (macOS of Windows) clone je de repository ergens onder de
Herd-map, op elke diepte. Herd serveert een map als die gelinkt is, of als hij
_direct_ in een geparkeerde map staat: `~/Herd/tle-2` werkt meteen,
`~/Herd/development/tle-2` pas na een link. `composer run setup` (of
`make herd`) linkt de map met `herd link --secure`, dus de site staat er meteen
en blijft draaien.

Gebruikt een andere map de sitenaam al, dan linkt setup niet over die naam heen.
Het zegt welke map het is, en je kiest zelf een andere naam met
`herd link --secure <andere-naam>`.

**Zonder Herd** draai je `composer run dev` (of `make dev`) en open je
`http://localhost:8000`.

## Inloggen en accounts

Setup seedt één lokaal account; `php artisan migrate:fresh --seed` (of
`make fresh yes=1`) maakt het opnieuw aan:

```
email:    test@example.com
password: password
```

| Waar                                      | Wat                                     |
| ----------------------------------------- | --------------------------------------- |
| `routes/auth.php`                         | Alle auth-routes                        |
| `app/Http/Controllers/Auth/`              | Eén controller per flow                 |
| `app/Http/Requests/Auth/LoginRequest.php` | Inloggen, maximaal vijf pogingen        |
| `resources/views/auth/`, `profile/`       | De pagina's, op de guest- en app-layout |

### E-mailverificatie aanzetten

Staat standaard uit. Haal in `app/Models/User.php` de `//` weg vóór
`implements` op de class-regel:

```php
class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
```

`make format` maakt van de class-naam daarna een import. Vanaf dan krijgt een
nieuw account een verificatielink, blijft `/dashboard` dicht tot die gevolgd is,
en kan de link opnieuw verstuurd worden vanaf de profielpagina.

### Waar de mails lokaal heen gaan

`.env.example` zet `MAIL_MAILER=log`: er wordt niets verstuurd, de mails komen in
`laravel.log` in `storage/logs/`. Vind de link met:

```bash
grep -o 'https\?://[^ )"<]*reset-password[^ )"<]*' storage/logs/laravel.log | tail -1
grep -o 'https\?://[^ )"<]*verify-email[^ )"<]*' storage/logs/laravel.log | tail -1
```

## Samenwerken

**Niemand commit op `main`.** `main` is altijd deploybaar, op `develop` komt het
werk samen, en een feature branch maak je vanaf `develop` en merge je daar weer
in.

```bash
git switch develop && git pull
git switch -c feature/waar-je-aan-werkt
# ... werk ...
make verify          # ongeveer zeven seconden; de pre-push hook draait het ook
git push -u origin feature/waar-je-aan-werkt
```

Het volledige model, met hotfixes en hoe twee mensen één branch delen, staat in
[docs/branching.md](docs/branching.md). Hoe we het werk plannen (projectbord,
issues, pull requests) staat in de [wiki](https://github.com/Richievdheij/tle-2/wiki).

## Projectstructuur

| Pad                | Wat er staat                                                   |
| ------------------ | -------------------------------------------------------------- |
| `app/`             | Models, controllers, form requests, policies, resources        |
| `resources/views/` | Blade: layouts, partials en anonieme components                |
| `resources/scss/`  | Het design system: tokens, base, layout, components, utilities |
| `resources/css/`   | Gewone CSS, voor wie liever geen SCSS schrijft                 |
| `database/`        | Migrations, factories en seeders                               |
| `tests/`           | Pest: Unit-, Feature- en Arch-tests                            |
| `scripts/`         | De checks en de hulpscripts                                    |
| `docs/`            | Branchmodel, datamodel (ERD) en de keuzes achter de toolchain  |

## Een pagina bouwen

1. Voeg een route toe in `routes/web.php`, bijvoorbeeld
   `Route::view('/about', 'about')->name('about');`.
2. Maak de view `about.blade.php` in `resources/views/` en zet hem in de layout:

   ```blade
   <x-layouts.app :title="__('About us')">
       <h1>{{ __('About us') }}</h1>
       <x-button href="{{ route('home') }}">{{ __('Back home') }}</x-button>
   </x-layouts.app>
   ```

3. Kies components uit `resources/views/components/`. Bovenaan elk bestand
   staat hoe je hem gebruikt en welke props hij heeft.
4. Extra styling? Zet het in `resources/css/app.css` (gewone CSS), of maak
   `resources/scss/components/_<naam>.scss` en `@forward` hem in de
   `_index.scss` van die map. Gebruik de tokens (`var(--spacing-md)`,
   `var(--color-text-primary)`) in plaats van losse waarden.

## Styling

**SCSS of CSS, allebei goed.** In de browser komt gewone CSS aan. Schrijf SCSS
in `resources/scss/`, of gewone CSS in `resources/css/app.css`: dezelfde tokens
en classes, native CSS nesting, en de `app`-laag die altijd boven het design
system wint. Voeg eerst een token toe voordat je een losse waarde gebruikt; een
hexcode in een component is precies wat de tokens moeten voorkomen.

## Documentatie

- [Wiki](https://github.com/Richievdheij/tle-2/wiki): hoe we het werk plannen en
  bijhouden: het projectbord, statussen, issues en pull requests.
- [docs/branching.md](docs/branching.md): `main`, `develop` en feature branches.
- [docs/erd.md](docs/erd.md): het datamodel als Mermaid-diagram. `make erd`
  tekent het opnieuw na een migration.
- [docs/toolchain.md](docs/toolchain.md): de checks en de keuzes erachter
  (Engels).
- [AGENTS.md](AGENTS.md): de handleiding voor coding agents.

## Licentie

**Alle rechten voorbehouden.** Dit is privéwerk, geen open source. Je mag het
niet kopiëren, gebruiken, aanpassen of verspreiden, ook niet als de repository
technisch bereikbaar is. Zie [LICENSE](LICENSE).

Het Laravel-skelet waarop dit gebouwd is, blijft MIT (© Taylor Otwell); welke
bestanden dat zijn, staat in de LICENSE.
