<?php

use App\Models\ShortUrl;
use App\Models\Visit;
use Database\Factories\ShortUrlFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeCreated', function () {
    return $this->ToBe(Response::HTTP_CREATED);
});

expect()->extend('toBeNoContent', function () {
    return $this->ToBe(Response::HTTP_NO_CONTENT);
});

expect()->extend('toBeUnprocessableEntity', function () {
    return $this->ToBe(Response::HTTP_UNPROCESSABLE_ENTITY);
});
/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * ShortUrl Factory
 *
 */
function shortUrl(): ShortUrlFactory
{
    return ShortUrlFactory::new();
}

/**
 * Create (store) a shortUrl
 *
 * @param array<string,mixed> $data
 * @return \Illuminate\Testing\TestResponse
 */
function storeShortUrl(array $data = [])
{
    return postJson(route('api.short-url.store'), $data);
}

/**
 * Access a ShortURL Stats
 *
 * @param string $code
 * @return \Illuminate\Testing\TestResponse
 */
function getStats(string $code)
{
    return getJson(route('api.short-url.stats.visits', $code));
}

/**
 * Access a ShortURL Stats
 *
 * @param string $code
 * @return \Illuminate\Testing\TestResponse
 */
function getLastVisit(string $code)
{
    return getJson(route('api.short-url.stats.last-visit', $code));
}

/**
 * Generates Visits with VisitFactory
 *
 * @param ShortUrl $shortUrl
 */
function createVisits(ShortUrl $shortUrl): void
{
    Visit::factory()
        ->count(12)
        ->state(new Sequence(
            ['created_at' => Carbon::now()->subDays(3)],
            ['created_at' => Carbon::now()->subDays(2)],
            ['created_at' => Carbon::now()->subDay()],
            ['created_at' => Carbon::now()]
        ))
        ->create([
            'short_url_id' => $shortUrl->id,
        ]);
}

function requiresMysql()
{
    if (DB::getDriverName() !== 'mysql') {
        test()->markTestSkipped('This test requires MySQL database');
    }

    return test();
}
