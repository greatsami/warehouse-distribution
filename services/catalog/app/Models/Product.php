<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use HasUlids;
    use Searchable;

    protected $fillable = [
        'name',
        'status',
        'description',
        'price',
        'cost',
        'weight',
        'dimensions',
        'stock',
        'category_id',
        'supplier_id',
        'warehouse_id',
    ];

    protected $casts = [
        'status' =>ProductStatus::class,
        'dimensions' => AsArrayObject::class,
        'price' => MoneyCast::class,
        'cost' => MoneyCast::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(related: Category::class, foreignKey: 'category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(related: Supplier::class, foreignKey: 'supplier_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(related: Warehouse::class, foreignKey: 'warehouse_id');
    }

    protected function makeAllSearchableUsing(EloquentBuilder $query): Builder
    {
        return $query->with([
            'category',
            'supplier',
            'warehouse',
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->getKey(),
            'name' => $this->getAttribute('name'),
            'status' => $this->getAttribute('status'),
            'description' => $this->getAttribute('description'),
            'price' => $this->getAttribute('price'),
            'cost' => $this->getAttribute('cost'),
            'weight' => $this->getAttribute('weight'),
            'dimensions' => $this->getAttribute('dimensions'),
            'stock' => $this->getAttribute('stock'),
            'category' => [
                'name' => $this->category->getAttribute('category_id'),
            ],
            'supplier' => [
                'name' => $this->supplier->getAttribute('supplier_id'),
                'reference' => $this->supplier->getAttribute('reference'),
            ],
            'warehouse' => [
                'name' => $this->warehouse->getAttribute('warehouse_id'),
            ],
        ];
    }
}
