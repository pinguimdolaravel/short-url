<?php

namespace Tests\Feature\ShortUrl;

use App\Models\ShortUrl;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class StatsTest extends TestCase
{

    /** @test */
    public function it_should_return_the_last_visit_on_the_short_url()
    {
        $shortUrl = ShortUrl::factory()->createOne();
        $this->get($shortUrl->code);

        $this->getJson(route('api.short-url.stats.last-visit', $shortUrl->code))
            ->assertSuccessful()
            ->assertJson([
                'last_visit' => $shortUrl->last_visit?->toIso8601String(),
            ]);

        $this->assertDatabaseHas('visits', [
            'short_url_id' => $shortUrl->id,
            'created_at'   => Carbon::now(),
        ]);
    }
}
