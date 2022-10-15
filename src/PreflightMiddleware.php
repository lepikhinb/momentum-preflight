<?php

declare(strict_types=1);

namespace Momentum\Preflight;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionParameter;
use Spatie\LaravelData\Data;

class PreflightMiddleware
{
    // @phpstan-ignore-next-line
    public function handle(Request $request, Closure $next)
    {
        if (! $request->header('X-Inertia-Preflight') || $request->isMethod('GET')) {
            return $next($request);
        }

        /** @var \Illuminate\Routing\Route $route */
        $route = app('router')->getCurrentRoute();

        if ($route->getAction('uses') instanceof Closure) {
            $method = new ReflectionFunction($route->getAction('uses'));
        } else {
            $controller = new ReflectionClass($route->getController());

            $method = $controller->getMethod($route->getActionMethod());
        }

        $requestClass = $this->getRequestClass($method);

        $this->validate($requestClass);

        throw ValidationException::withMessages([]);
    }

    protected function getRequestClass(ReflectionFunction|ReflectionMethod $method): string
    {
        /** @var ReflectionParameter */
        $parameter = collect($method->getParameters())
            ->filter(fn (ReflectionParameter $parameter) => $parameter->hasType())
            ->first(function (ReflectionParameter $parameter) {
                // @phpstan-ignore-next-line
                $reflection = new ReflectionClass($parameter->getType()->getName());

                return $reflection->isSubclassOf(FormRequest::class)
                    || $reflection->isSubclassOf(Data::class);
            });

        // @phpstan-ignore-next-line
        return $parameter->getType()->getName();
    }

    protected function validate(string $requestClass): void
    {
        $request = app($requestClass);

        // @phpstan-ignore-next-line
        if ($request instanceof Data) {
            $request->validate($request->all());
        }
    }
}
