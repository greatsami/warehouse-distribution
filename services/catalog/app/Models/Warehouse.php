<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\WarehouseStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Warehouse extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable= [
        'name',
        'manager',
        'email',
        'status',
        'address',
    ];

    protected $casts = [
        'status' => WarehouseStatus::class,
        'address' => AsArrayObject::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(related: Product::class, foreignKey: 'warehouse_id');
    }

}
