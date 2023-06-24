<?php
declare(strict_types=1);
namespace App\Casts;

use Brick\Math\Exception\MathException;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MoneyCast implements CastsAttributes
{

    /**
     * @throws UnknownCurrencyException|RoundingNecessaryException|NumberFormatException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Money
    {
        return Money::of(amount: $value, currency: 'GBP');
    }

    /**
     * @param Model $model
     * @param string $key
     * @param int $value
     * @param array $attributes
     * @return mixed
     * @throws MathException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
