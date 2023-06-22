<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory;
    use HasUlids;
    use Notifiable;

    protected $fillable = [
        'name',
        'website',
        'email'
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(
            related: Client::class,
            foreignKey: 'company_id',
        );
    }

    public function members(): HasMany
    {
        return $this->hasMany(
            related: Member::class,
            foreignKey: 'company_id',
        );
    }

}
