<?php

use Illuminate\Support\Carbon;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use Symfony\Component\HttpFoundation\Response;

it('should return the last visit on the short url', function () {
    $shortUrl = shortUrl()->create();

    get($shortUrl->code);

    $response = getLastVisit($shortUrl->code);

    expect($response)
        ->status()->toBe(Response::HTTP_OK)
        ->content()
        ->json()
        ->toMatchArray(['last_visit' => $shortUrl->last_visit?->toIso8601String()]);

    assertDatabaseHas('visits', [
        'short_url_id' => $shortUrl->id,
        'created_at'   => Carbon::now(),
    ]);
})->requiresMysql();

it('should return the amount per day of visits with a total', function () {
    $shortUrl = shortUrl()->create();

    createVisits($shortUrl);

    $response = getStats($shortUrl->code);

    expect($response)
        ->status()->toBe(Response::HTTP_OK)
        ->content()
        ->json()
        ->toMatchArray([
            'total'  => 12,
            'visits' => [
                [
                    'date'  => Carbon::now()->subDays(3)->format('Y-m-d'),
                    'count' => 3,
                ],
                [
                    'date'  => Carbon::now()->subDays(2)->format('Y-m-d'),
                    'count' => 3,
                ],
                [
                    'date'  => Carbon::now()->subDay()->format('Y-m-d'),
                    'count' => 3,
                ],
                [
                    'date'  => Carbon::now()->format('Y-m-d'),
                    'count' => 3,
                ],
            ],
        ]);
})->requiresMysql();
