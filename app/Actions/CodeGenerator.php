<?php

namespace App\Actions;

use Illuminate\Support\Str;

class CodeGenerator
{
    public function run(): string
    {
        return Str::random(5);
    }
}
