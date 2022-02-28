<?php

namespace App\Actions;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class CodeGenerator
{
    public function run(): string
    {
        $code = Str::random(5);

        return ShortUrl::where('code', $code)->count()
            ? $this->run()
            : $code;
    }
}
