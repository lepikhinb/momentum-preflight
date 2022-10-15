<?php

declare(strict_types=1);

namespace Momentum\Preflight\Tests;

use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__ . '/Stubs');
        Inertia::setRootView('app');
    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
            LaravelDataServiceProvider::class,
        ];
    }
}
