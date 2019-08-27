<?php

namespace App\Rules;

use Illuminatech\Validation\Composite\CompositeRule;

class MobileRule extends CompositeRule
{

    protected function rules(): array
    {
        return [
            'regex:/^1[0-9]{10}$/'
        ];
    }

}
