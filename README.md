# Momentum Preflight

Momentum Preflight is a Laravel package that lets you implement realtime backend-driven request validation for Inertia apps.

Validate form requests using Inertia form helper just like you already do, without running controllers' code.

- [**Advanced Inertia**](#advanced-inertia)
- [**Installation**](#installation)
  - [**Laravel**](#laravel)
  - [**Vue 3**](#vue-3)
- [**Usage**](#usage)
- [**Momentum**](#momentum)

## Installation

### Laravel

Install the package into your Laravel app.

```bash
composer require based/momentum-preflight
```

Register the `PreflightMiddleware` middleware.

```php
<?php

Route::post('register', RegisterController::class)
  ->middleware(PreflightMiddleware::class);
```

### Vue 3

> The frontend package is only for Vue 3 now due to its wide adoption within the Laravel community.

Install the [frontend package](https://github.com/lepikhinb/momentum-preflight-plugin).

```bash
npm i momentum-preflight
# or
yarn add momentum-preflight
```

## Usage

Preflight works well with both [FormRequests](https://laravel.com/docs/9.x/validation#form-request-validation) and [Laravel Data](https://spatie.be/docs/laravel-data/v2/as-a-data-transfer-object/request-to-data-object). Due to the simplicity of the approach, it doesn't support the inline `$request->validate(...)` method.

```php
<?php

class RegisterController
{
    public function __invoke(RegisterRequest $request)
    {
        ...
    }
}
```

```ts
import { useForm } from "inertia/inertia-vue3";
import { useValidate } from "momentum-preflight";

const form = useForm({ name: "" });

const validate = useValidate(form, "/register", { debounce: 500 });

watch(
  () => form.data(),
  () => validate()
);
```

The package performs validation for all defined rules. However, you can specify exact fields so that all errors don't appear together once you start typing.

```vue
<script setup>
import { useForm } from "inertia/inertia-vue3";
import { useValidate } from "momentum-preflight";

const form = useForm({ name: "" });

const validate = useValidate(form, "/register");
</script>

<template>
  <div>
    <input v-model="form.name" @blur="validate('name')" />

    <span v-if="form.errors.name">{{ form.errors.name }}</span>
  </div>
</template>
```

## Advanced Inertia

[<img src="https://advanced-inertia.com/og.png" width="420px" />](https://advanced-inertia.com)

Take your Inertia.js skills to the next level with my book [Advanced Inertia](https://advanced-inertia.com/).
Learn advanced concepts and make apps with Laravel and Inertia.js a breeze to build and maintain.

## Momentum

Momentum is a set of packages designed to improve your experience building Inertia-powered apps.

- [Modal](https://github.com/lepikhinb/momentum-modal) — Build dynamic modal dialogs for Inertia apps
- [Preflight](https://github.com/lepikhinb/momentum-preflight) — Realtime backend-driven validation for Inertia apps
- [Paginator](https://github.com/lepikhinb/momentum-paginator) — Headless wrapper around Laravel Pagination
- [Trail](https://github.com/lepikhinb/momentum-trail) — Frontend package to use Laravel routes with Inertia
- [Lock](https://github.com/lepikhinb/momentum-lock) — Frontend package to use Laravel permissions with Inertia
- [Layout](https://github.com/lepikhinb/momentum-layout) — Persistent layouts for Vue 3 apps
- [Vite Plugin Watch](https://github.com/lepikhinb/vite-plugin-watch) — Vite plugin to run shell commands on file changes

## Credits

- [Boris Lepikhin](https://twitter.com/lepikhinb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
