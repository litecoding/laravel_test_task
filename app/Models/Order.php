<?php

namespace App\Models;

use App\Enum\Status;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // Зв’язок з моделлю User (кожне замовлення належить одному користувачу)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
