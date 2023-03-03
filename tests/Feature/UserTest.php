<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testcreateuser(): void
    {
        $data=User::factory()->make()->toArray();
        $data['password']=12345678;
        User::create($data);
        $this->assertDatabaseHas('users',$data);
    }
}
