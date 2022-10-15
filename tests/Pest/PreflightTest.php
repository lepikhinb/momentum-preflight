<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Middleware as InertiaMiddleware;
use Momentum\Preflight\PreflightMiddleware;
use Momentum\Preflight\Tests\Stubs\ExampleController;
use function Pest\Laravel\followingRedirects;
use function Pest\Laravel\post;

beforeEach(function () {
    Route::middleware(InertiaMiddleware::class, PreflightMiddleware::class)->group(function () {
        Route::get('/', fn () => Inertia::render('base'));
        Route::post('form-request', [ExampleController::class, 'formRequest']);
        Route::post('laravel-data', [ExampleController::class, 'laravelData']);
    });
});

test('validate default form requests', function () {
    post('form-request', [
        'email' => 'yo',
        'name' => '',
    ], [
        'X-Inertia' => true,
        'X-Inertia-Preflight' => true,
    ])
        ->assertInvalid(['email', 'name']);
});

test('validate laravel-data requests', function () {
    post('laravel-data', [
        'email' => 'yo',
        'name' => '',
    ], [
        'X-Inertia' => true,
        'X-Inertia-Preflight' => true,
    ])
        ->assertInvalid(['email', 'name']);
});

test('validated request does not go further', function () {
    followingRedirects()
        ->post('form-request', [
            'email' => 'yo@example.net',
            'name' => 'boris',
        ], [
            'X-Inertia' => true,
            'X-Inertia-Preflight' => true,
        ])
        ->assertSuccessful()
        ->assertValid();
});

test('regular request does go further', function () {
    followingRedirects()
        ->post('form-request', [
            'email' => 'yo@example.net',
            'name' => 'boris',
        ], [
            'X-Inertia' => true,
        ])
        ->assertStatus(503);
});
