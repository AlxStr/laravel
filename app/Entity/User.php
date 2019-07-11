<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Mockery\Exception;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @property string name
 * @property string email
 * @property string password
 * @property string status
 * @property string verify_token
 */
class User extends Authenticatable
{
    const STATUS_WAIT   = 'wait';
    const STATUS_ACTIVE = 'active';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public static function register(
        string $name,
        string $email,
        string $password
    ): self {
        return static::create([
            'name'         => $name,
            'email'        => $email,
            'password'     => bcrypt($password),
            'verify_token' => Str::uuid(),
            'status'       => self::STATUS_WAIT,
        ]);
    }

    /**
     * @param string $name
     * @param string $email
     *
     * @return self
     */
    public static function new(
        string $name,
        string $email
    ): self {
        return static::create([
            'name'         => $name,
            'email'        => $email,
            'password'     => bcrypt(Str::random()),
            'status'       => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    /**
     * @return void
     */
    public function verify(): void
    {
        if (true === $this->isActive()) {
            throw new \DomainException('User is already verified.');
        }

        $this->update([
            'status'       => self::STATUS_ACTIVE,
            'verify_token' => null
        ]);
    }
}
