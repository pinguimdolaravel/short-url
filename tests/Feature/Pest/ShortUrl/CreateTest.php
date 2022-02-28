<?php

use App\Facades\Actions\CodeGenerator;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\postJson;

it('should be able to create a short url', function () {
    $randomCode = Str::random(5);

    CodeGenerator::shouldReceive('run')
        ->once()
        ->andReturn($randomCode);

    postJson(
        route('api.short-url.store'),
        ['url' => 'https://www.google.com']
    )
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            'short_url' => config('app.url') . '/' . $randomCode,
        ]);

    $this->assertDatabaseHas('short_urls', [
        'url' => 'https://www.google.com',
        'short_url' => config('app.url') . '/' . $randomCode,
        'code' => $randomCode,
    ]);
});

test('url should be a valid url', function () {
    $this->postJson(
        route('api.short-url.store'),
        ['url' => 'not-valid-url']
    )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors([
            'url' => __('validation.url', ['attribute' => 'url']),
        ]);
});

it('should return the existed code if the url is the same', function () {
    ShortUrl::factory()->create([
        'url' => 'https://www.google.com',
        'short_url' => config('app.url') . '/123456',
        'code' => '123456',
    ]);

    postJson(
        route('api.short-url.store'),
        ['url' => 'https://www.google.com']
    )->assertJson([
        'short_url' => config('app.url') . '/123456',
    ]);

    $this->assertDatabaseCount('short_urls', 1);
});


it('should return a unique code - v1', function () {

    //esse teste parece meio óbvio que passa já que só tem que gerar um code diferente...
    //nasminhas contas temos um arranjo com repetição de 62 (26 minúsculas + 26 mai[usculas + 10 números) elementos tomados 5 a 5
    //AR(62, 5) = 62^5 = 916.132.832 possibilidades...

    //repito o teste de criação de URL...
    //repito o teste de criação de URL...
    $randomCode = Str::random(5);

    CodeGenerator::shouldReceive('run')
        ->once()
        ->andReturn($randomCode);

    postJson(
        route('api.short-url.store'),
        ['url' => 'https://www.google.com']
    )
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            'short_url' => config('app.url') . '/' . $randomCode,
        ]);

    $this->assertDatabaseHas('short_urls', [
        'url' => 'https://www.google.com',
        'short_url' => config('app.url') . '/' . $randomCode,
        'code' => $randomCode,
    ]);
    //repito o teste de criação de URL...
    //repito o teste de criação de URL...

    //gero novo código e comparo com o gerado na criação...
    CodeGenerator::shouldReceive('run');
    $newCode = CodeGenerator::run();
    $this->assertNotEquals($randomCode, $newCode);
});


it('should return a non existing code - v2', function () {
    //tentando fazer um teste que tenha possibilidades reais de dar erro se o codegenerator não estiver funcionando como esperado

    //defino um range para todas as letras
    $range = array_merge(range('a', 'z'), range('A', 'Z'));

    //uso a factory para registrar uma url com cada letra possível
    ShortUrl::factory(52)
        ->sequence(fn($seq) => ['code' => $range[$seq->index]])
        ->create();

    //instancio o CodeGenerator passando parâmetro para o construtor
    $codeGenerator = new App\Actions\CodeGenerator(1);

    //as únicas possibilidades com $length = 1 são números de 0 a 9 já que Str::random() gera caracteres alfanuméricos
    $this->assertIsNumeric($codeGenerator->run());
});
