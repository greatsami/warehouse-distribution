<?php
declare(strict_types=1);
namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read  string $id
 * @property-read  string $name
 * @property-read  string $email
 * @property-read  CarbonInterface $created_at
 * @property-read  CarbonInterface $updated_at
 */
final class Client extends Model
{
    use HasFactory;
    use HasUlids;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'company_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(
            related: Company::class,
            foreignKey: 'company_id',
        );
    }

    public function membership(): HasOne
    {
        return $this->hasOne(
            related: Member::class,
            foreignKey: 'client_id',
        );
    }

}
