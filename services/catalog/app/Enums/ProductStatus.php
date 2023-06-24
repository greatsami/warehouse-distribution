<?php
declare(strict_types=1);
namespace App\Enums;

enum ProductStatus: string
{

    case IN_STOKE = 'in-stoke';
    case SOLD_OUT = 'sold-out';
    case ON_ORDER = 'on-order';

}
