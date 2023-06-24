<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Category extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
        'status',
        'description',
    ];

    protected $casts = [
        'status' => CategoryStatus::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(related: Product::class, foreignKey: 'category_id');
    }

}
