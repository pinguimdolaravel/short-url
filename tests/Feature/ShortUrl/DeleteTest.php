<?php

namespace Tests\Feature\ShortUrl;

use App\Models\ShortUrl;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @dataProvider urls
     * @test
     */
    public function it_can_delete_a_short_url($url)
    {
        $shortUrl = ShortUrl::factory()->create(['code' => $url]);
        $this->deleteJson(route('api.short-url.destroy', $shortUrl->code))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('short_urls', [
            'id' => $shortUrl->id,
        ]);
    }

    public function urls()
    {
        return [
            'with abcd' => ['abcd'],
            'with dvbc' => ['dvbc'],
        ];
    }
}
