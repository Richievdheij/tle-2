<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('offers a guest the log in button and no account menu', function (): void {
    get('/')
        ->assertOk()
        ->assertSeeHtml('href="'.route('login').'"')
        ->assertDontSeeHtml(route('logout'))
        ->assertDontSee('Account menu');
});

it('shows a signed-in user the user menu with their profile and log out', function (): void {
    $user = User::factory()->create(['name' => 'Ada Lovelace', 'email' => 'ada@example.com']);

    actingAs($user)->get('/dashboard')
        ->assertSee("You're logged in!")
        ->assertSee('Account menu')
        ->assertSee('Ada Lovelace')
        ->assertSee('ada@example.com')
        ->assertSee('AL')
        ->assertSeeHtml(route('profile.edit'))
        ->assertSeeHtml(route('logout'))
        ->assertDontSeeHtml('href="'.route('login').'"');
});

it('marks the current page in the navigation', function (): void {
    $user = User::factory()->create();

    $html = actingAs($user)->get('/profile')->getContent();

    expect($html)->toMatch('#href="'.preg_quote(route('profile.edit'), '#').'"\s+aria-current="page"#');
});

it('renders a navigation link whose route does not exist yet as a placeholder', function (): void {
    $html = get('/')->getContent();

    expect(Route::has('projects.index'))->toBeFalse()
        ->and($html)->toContain('Projects')
        ->and($html)->toMatch('#<a\s+class="nav-link"\s*>\s*<span class="nav-link__label">Projects</span>#');
});

it('links a navigation entry as soon as its route exists', function (): void {
    Route::get('/projecten', fn (): string => '')->name('projects.index');
    Route::getRoutes()->refreshNameLookups();

    get('/')->assertSeeHtml('href="'.url('/projecten').'"');
});

it('carries the same links in the hamburger menu', function (): void {
    get('/')->assertSeeHtmlInOrder(['class="mobile-menu"', 'Projects', 'Events', 'Donate', 'href="'.route('login').'"']);
});

it('fills the footer with the link columns and the copyright', function (): void {
    get('/')
        ->assertSee('Discover')
        ->assertSee('About us')
        ->assertSee('Accessibility')
        ->assertSeeHtml('© '.now()->year.' '.config()->string('app.name'));
});
