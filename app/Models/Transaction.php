<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'ref_num',
        'order_id',
        'status',
        'card_number',
        'amount',
        'user_id'
    ];
}
