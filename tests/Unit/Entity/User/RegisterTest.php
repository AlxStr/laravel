<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Registe User test
 *
 * @package Tests\Unit\Entity\User
 */
class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Registration request test
     *
     * @return void
     */
    public function testRequest(): void
    {
        $user = User::register(
            $name = 'name',
            $email = 'email',
            $password = 'password'
        );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);
        self::assertNotEquals($password, $user->password);

        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertFalse($user->isAdmin());
    }

    /**
     * User verify test
     *
     * @return void
     */
    public function testVerify(): void
    {
        $user = User::register('name', 'email', 'password');

        $user->verify();

        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
    }

    /**
     * User already verified test
     *
     * @return void
     */
    public function testAlreadyVerified(): void
    {
        $user = User::register('name', 'email', 'password');

        $user->verify();

        $this->expectExceptionMessage('User is already verified.');
        $user->verify();
    }
}
