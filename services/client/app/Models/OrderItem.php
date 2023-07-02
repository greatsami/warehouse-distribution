<?php
declare(strict_types=1);
namespace App\Models;

use Brick\Money\Money;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read string $id
 * @property-read string $product
 * @property-read int $quantity
 * @property-read Money $price
 * @property-read int $discount
 */
final class OrderItem extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable =[
        'product',
        'quantity',
        'price',
        'discount',
        'order_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            related: Order::class,
            foreignKey: 'order_id',
        );
    }
}
