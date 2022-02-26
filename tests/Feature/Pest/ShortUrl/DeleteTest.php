<?php

use App\Models\ShortUrl;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

it('can delete a short url', function () {
    $shortUrl = ShortUrl::factory()->create();

    $response = deleteJson(route('api.short-url.destroy', $shortUrl->code));

    expect($response)
        ->status()
        ->toBeNoContent();

    assertDatabaseMissing('short_urls', ['id' => $shortUrl->id]);
});
