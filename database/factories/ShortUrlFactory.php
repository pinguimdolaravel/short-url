<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortUrlFactory extends Factory
{
    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            'url'       => $this->faker->url(),
            'short_url' => $this->faker->url(),
            'code'      => $this->faker->word(),
        ];
    }
}
