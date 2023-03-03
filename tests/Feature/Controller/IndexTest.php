<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testindex(): void
    {
        $response = $this->get(route('index'));

        $response->assertStatus(200);
    }
    
}
