<?php

declare(strict_types=1);

namespace Momentum\Preflight\Tests\Stubs;

class ExampleController
{
    public function formRequest(FormRequest $request)
    {
        abort(503);
    }

    public function laravelData(LaravelDataRequest $request)
    {
        abort(503);
    }
}
