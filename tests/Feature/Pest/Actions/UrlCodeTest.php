<?php

use App\Facades\Actions\UrlCode;
use App\Models\ShortUrl;

it('generates a 5 characters code')
    ->expect(fn () => UrlCode::generate())
    ->toBeString()
    ->toHaveLength(5);

test('codes cannot be repeated', function () {
    $code = '12345';

    shortUrl()->create(['code' => $code]);

    expect(ShortUrl::all())
        ->count()->toBe(1)
        ->first()
        ->code->toBe($code);

    $newCode = UrlCode::generate($code);

    expect($newCode)
        ->toBeString()
        ->toHaveLength(5)
        ->not->toBe($code);
});
