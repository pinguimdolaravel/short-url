<?php

declare(strict_types = 1);

namespace App\Actions;

use App\Models\ShortUrl;

class UrlCode
{
    /**
     * Generates the code to be used in an ShortURL
     *
     * @param string|null $code
     * @return string
     */
    public function generate(string $code = null): string
    {
        $code = $code ?? str()->random(5);

        if (ShortUrl::where('code', $code)->exists()) {
            return $this->generate();
        }

        return $code;
    }
}
