<?php

namespace App\Actions;

use App\Models\ShortUrl;
use Illuminate\Support\Str;

class CodeGenerator
{
    //definindo um construtor para chamar a classo passando length diferente nos testes por exemplo
    public function __construct(
        private int $length = 0
    )
    {
        $this->length = $length ?? config('app.short_url_code_length');
    }

    public function run(): string
    {
        $code = Str::random($this->length);

        return ShortUrl::where('code', $code)->count()
            ? $this->run()
            : $code;
    }
}
