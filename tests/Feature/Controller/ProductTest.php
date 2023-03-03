<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // @test
    public function test_product(): void
    {
        $response = $this->get(route('index.product'));

        $response->assertStatus(200);
        $response->assertViewIs('product');

    }
}
