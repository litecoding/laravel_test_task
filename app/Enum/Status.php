<?php

namespace App\Enum;

enum Status: string
{
    case NEW = "New";
    case PROCESSING = "Processing";
    case SENT = "Sent";
    case DELIVERED = "Delivered";

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
