<?php
declare(strict_types=1);
namespace App\Enums;

enum OrderStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case PICKING = 'picking';
    case SHIPPING = 'shipping';
    case FULFILLED = 'fulfilled';
}
