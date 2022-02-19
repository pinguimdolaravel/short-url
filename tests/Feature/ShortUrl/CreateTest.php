<?php

namespace Tests\Feature\ShortUrl;

use App\Facades\Actions\CodeGenerator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_create_a_short_url()
    {
        $randomCode = Str::random(5);

        CodeGenerator::shouldReceive('run')
            ->once()
            ->andReturn($randomCode);

        $this->postJson(
            route('api.short-url.store'),
            ['url' => 'https://www.google.com']
        )->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'short_url' => config('app.url') . '/' . $randomCode,
            ]);

        $this->assertDatabaseHas('short_urls', [
            'url'       => 'https://www.google.com',
            'short_url' => config('app.url') . '/' . $randomCode,
            'code'      => $randomCode,
        ]);
    }

    /** @test */
    public function url_should_be_valid_url()
    {
        $this->postJson(
            route('api.short-url.store'),
            ['url' => 'not-valid-url']
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'url' => __('validation.url', ['attribute' => 'url']),
            ]);
    }
}
