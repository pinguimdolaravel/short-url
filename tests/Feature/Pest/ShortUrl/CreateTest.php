<?php

use App\Facades\Actions\UrlCode;
use App\Models\ShortUrl;
use Illuminate\Support\Str;

it('successfully creates a short url', function () {
    $randomCode = Str::random(5);

    UrlCode::shouldReceive('generate')
        ->once()
        ->andReturn($randomCode);

    $testUrl = config('app.url') . '/' . $randomCode;

    $response = storeShortUrl(['url' => 'https://www.google.com']);

    expect($response)
        ->status()->toBeCreated()
        ->content()
        ->json()
        ->toMatchArray(['short_url' => $testUrl]);

    expect(ShortUrl::count())->toBe(1);

    expect(ShortUrl::first())
        ->url->ToBe('https://www.google.com')
        ->code->toBe($randomCode)
        ->short_url->toBe($testUrl);
});

it('rejects an invalid URL', function () {
    $response = storeShortUrl(['url' => 'not-valid-url']);

    expect($response)
        ->status()->toBeUnprocessableEntity()
        ->content()
        ->json()
        ->toMatchArray([
            "message" => "The url must be a valid URL.",
            "errors"  => [
                "url" => ["The url must be a valid URL."]
            ]
        ]);
});

it('returns the existing code when the URL already exists', function () {
    $code = '123456';
    $shortUrl = config('app.url') . '/' . $code;

    shortUrl()->create([
        'url'       => 'https://www.google.com',
        'short_url' => $shortUrl,
        'code'      => $code
    ]);

    $response = storeShortUrl(['url' => 'https://www.google.com']);

    expect($response)
        ->status()->toBeCreated()
        ->content()
        ->json()
        ->toMatchArray(['short_url' => $shortUrl]);

    expect(ShortUrl::count())->toBe(1);
});
