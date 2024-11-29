<?php

namespace App\Models;

use App\Enum\Status;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'product_name',
        'amount',
        'user_id',
        'status'
    ];

    protected $casts = [
        'status' => Status::class,
    ];
}
