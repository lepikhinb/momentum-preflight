<?php

namespace Momentum\Preflight\Tests\Stubs;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ];
    }
}
