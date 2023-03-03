<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Transaction::class;

    public function definition(): array
    {
        return [
            'ref_num'=>Str::random(10),
                'order_id'=>Str::random(10),
                'status'=>0,
                'card_number'=>6037998106039587,
                'amount'=>5000,
                'user_id' => 1
        ];

}
}
