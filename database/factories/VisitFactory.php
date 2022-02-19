<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'ip_address'   => $this->faker->ipv4,
            'user_agent'   => $this->faker->userAgent,
            'short_url_id' => ShortUrl::factory(),
        ];
    }
}
