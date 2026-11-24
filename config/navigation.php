<?php

declare(strict_types=1);

/*
 * Navigation for the navbar, mobile menu and footer. Each entry: `label` (passed through __()),
 * `route` (a route name; a missing route renders as a placeholder link), `active` (route pattern
 * for aria-current, defaults to the route), `icon` (an <x-icon> name), `guest` / `auth` (show only
 * to signed-out / signed-in visitors).
 */

return [

    // The navbar links.
    'main' => [
        ['label' => 'Projects', 'route' => 'projects.index', 'active' => 'projects.*'],
        ['label' => 'Events', 'route' => 'events.index', 'active' => 'events.*'],
        ['label' => 'Donate', 'route' => 'donate', 'active' => 'donate*'],
    ],

    // The signed-in user's menu, above "Log out".
    'account' => [
        ['label' => 'My profile', 'route' => 'profile.edit', 'active' => 'profile.*', 'icon' => 'user'],
        ['label' => 'My donations', 'route' => 'donations.index', 'active' => 'donations.*', 'icon' => 'download'],
        ['label' => 'My events', 'route' => 'my-events.index', 'active' => 'my-events.*', 'icon' => 'calendar'],
    ],

    // The footer's link columns, keyed by heading.
    'footer' => [
        'Discover' => [
            ['label' => 'Projects', 'route' => 'projects.index'],
            ['label' => 'Events', 'route' => 'events.index'],
            ['label' => 'Donate', 'route' => 'donate'],
        ],
        'Account' => [
            ['label' => 'Log in', 'route' => 'login', 'guest' => true],
            ['label' => 'My donations', 'route' => 'donations.index'],
            ['label' => 'My profile', 'route' => 'profile.edit'],
        ],
        'About us' => [
            ['label' => 'About TLE2', 'route' => 'about'],
            ['label' => 'Contact', 'route' => 'contact'],
            ['label' => 'FAQ', 'route' => 'faq'],
        ],
    ],

    // The footer's bottom bar.
    'legal' => [
        ['label' => 'Privacy', 'route' => 'privacy'],
        ['label' => 'Cookies', 'route' => 'cookies'],
        ['label' => 'Accessibility', 'route' => 'accessibility'],
    ],

];
