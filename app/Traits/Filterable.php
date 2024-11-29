<?php

namespace App\Traits;

use App\Enum\Status;

trait Filterable
{
    public function scopeFilter($query, array $filters)
    {
        // Фільтр по назві продукту
        if (!empty($filters['product_name'])) {
            $query->where('product_name', 'like', '%' . $filters['product_name'] . '%');
        }

        // Фільтр по кількості
        if (!empty($filters['amount_min'])) {
            $query->where('amount', '>=', $filters['amount_min']);
        }

        if (!empty($filters['amount_max'])) {
            $query->where('amount', '<=', $filters['amount_max']);
        }

        // Фільтр по користувачу
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Фільтр по статусу (перевірка на валідність Enum)
        if (!empty($filters['status']) && Status::tryFrom($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
