<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
      $data=Transaction::factory()->make()->toArray();
        Transaction::create($data);
        $this->assertDatabaseHas('transactions',$data);
    }
}
