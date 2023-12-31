<?php
declare(strict_types=1);
namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Throwable;

final readonly class AuthenticationService
{

    public function __construct(
        private DatabaseManager $database,
    )
    {
    }

    /**
     * @param array{name:string,email:string,password:string} $data
     * @return User|Model
     * @throws Throwable
     */
    public function createUser(array $data): User|Model
    {
        return $this->database->transaction(
            callback: fn () => User::query()->create($data),
            attempts: 2
        );
    }

    /**
     * @param User<Authenticatable> $user
     * @return string
     */
    public function createAccessToken(User $user): string
    {
        // create an api token
        $token = Str::random(40);

        // store in cache
        Redis::set($token, \Safe\json_encode(
            value: [
                'id' => $user->getKey(),
                'role' => $user->getAttribute('role')
            ],
            flags: JSON_THROW_ON_ERROR,
        ));

        // return the token
        return $token;
    }
}
