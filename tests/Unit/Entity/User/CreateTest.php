<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Create User test
 *
 * @package Tests\Unit\Entity\User
 */
class CreateTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * New User test
     *
     * @return void
     */
    public function testNew(): void
    {
        $user = User::new(
            $name = 'name',
            $email = 'email'
        );

        self::assertNotEmpty($user);

        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);

        self::assertTrue($user->isActive());
    }
}
