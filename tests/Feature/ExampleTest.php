<?php

use App\Models\ShortUrl;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    $this->randomCode = \Illuminate\Support\Str::random(6);
});

it('has example page', function () {
    $shortUrl = ShortUrl::factory()->create(['code' => 'abcd']);

    expect($this->randomCode)
        ->toBeString();

    ray($this->randomCode . ':: first test');

    expect($shortUrl)
        ->code
        ->toBeString()
        ->toBe('abcd')
        ->toHaveLength(4)
        ->url
        ->toBeString();

    expect([1, 2, 3])
        ->toBeArray()
        ->toHaveCount(3);
})->only();

it("should be able to delete a short url", function () {

    expect($this->randomCode)
        ->toBeString();

    ray($this->randomCode . ':: second test');

    $shortUrl = ShortUrl::factory()->create();
    $route    = route('api.short-url.destroy', $shortUrl->code);

    expect(deleteJson($route))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseMissing('short_urls', [
        'id' => $shortUrl->id,
    ]);
});

it('should return a no content status when deleting a short url', function ($shortUrl) {
    deleteJson(route('api.short-url.destroy', $shortUrl->code))
        ->assertStatus(Response::HTTP_NO_CONTENT);
})
    ->with([
        'with abcd' => fn () => ShortUrl::factory()->create(['code' => 'abcd']),
        'with dvbcg' => fn () => ShortUrl::factory()->create(['code' => 'dvbcg']),
    ]);

