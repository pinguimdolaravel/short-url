<?php

use App\Models\ShortUrl;
use function Pest\Laravel\deleteJson;

it('can delete a short url', function () {
    $shortUrl = shortUrl()->create();

    $response = deleteJson(route('api.short-url.destroy', $shortUrl->code));

    expect($response)
        ->status()
        ->toBeNoContent();
});

it('can delete a short url [HIGH ORDER]')
    ->tap(fn ()    => $this->code = shortUrl()->create()->code)
    ->tap(fn ()    => $this->response = deleteJson(route('api.short-url.destroy', $this->code)))
    ->expect(fn () => $this->response)
    ->status()->toBeNoContent()
    ->expect(fn () => $this->count = ShortUrl::count())
    ->toBe(0);
