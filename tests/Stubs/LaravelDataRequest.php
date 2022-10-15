<?php

namespace Momentum\Preflight\Tests\Stubs;

use Spatie\LaravelData\Attributes\Validation;
use Spatie\LaravelData\Data;

class LaravelDataRequest extends Data
{
    public function __construct(
        public string $name,
        #[Validation\Email]
        public string $email
    ) {
    }
}
