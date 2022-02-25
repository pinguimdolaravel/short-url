<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Example2Test extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function it_has_example_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
