<?php

namespace Tests\Feature\ShortUrl;

use App\Models\ShortUrl;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function it_can_delete_a_short_url()
    {
        $shortUrl = ShortUrl::factory()->create();

        $this->deleteJson(route('api.short-url.destroy', $shortUrl->code))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('short_urls', [
            'id' => $shortUrl->id,
        ]);
    }
}
