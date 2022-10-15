# Momentum Preflight

Momentum Preflight is a Laravel package that lets you implement realtime backend-driven request validation for Inertia apps.

Validate form requests using Inertia form helper just like you already do, without running controllers' code.

- [**Advanced Inertia**](#advanced-inertia)
- [**Installation**](#installation)
  - [**Laravel**](#laravel)
  - [**Vue 3**](#vue-3)
- [**Usage**](#usage)
- [**Momentum**](#momentum)

## Advanced Inertia

[<img src="https://advanced-inertia.com/og5.png" width="420px" />](https://advanced-inertia.com)

Make Inertia-powered frontend a breeze to build and maintain with my upcoming book [Advanced Inertia](https://advanced-inertia.com/). Join the waitlist and get **20% off** when the book is out.

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

Install the frontend package.

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
import { useForm } from "inertia/inertia-vue3"
import { useValidate } from "momentum-preflight"

const form = useForm({ name: "" })

const validate = useValidate(form, "/register", { debounce: 500 })

watch(
  () => form.data(),
  () => validate()
)
```

The package performs validation for all defined rules. However, you can specify exact fields so that all errors don't appear together once you start typing.

```vue
<script setup>
import { useForm } from "inertia/inertia-vue3"
import { useValidate } from "momentum-preflight"

const form = useForm({ name: "" })

const validate = useValidate(form, "/register")
</script>

<template>
  <div>
    <input v-model="form.name" @blur="validate('name')" />

    <span v-if="form.errors.name">{{ form.errors.name }}</span>
  </div>
</template>
```

## Momentum

Momentum is a set of packages designed to bring back the feeling of working on a single codebase to Inertia-powered apps.

- [Modal](https://github.com/lepikhinb/momentum-modal) — Build dynamic modal dialogs for Inertia apps
- [Preflight](https://github.com/lepikhinb/momentum-preflight) — Realtime backend-driven validation for Inertia apps
- [Paginator](https://github.com/lepikhinb/momentum-paginator) — Headless wrapper around Laravel Pagination
- State — Laravel package to manage the frontend state of Inertia apps _(coming soon)_
- Router — Frontend plugin to use Laravel routes with Inertia _(coming soon)_
- Permissions — Frontend plugin to use your Laravel permission with Inertia _(coming soon)_
- Locale — Use your Laravel translation files with Inertia _(coming soon)_

## Credits

- [Boris Lepikhin](https://twitter.com/lepikhinb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
