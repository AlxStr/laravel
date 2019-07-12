<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class RoleTest
 *
 * @package Tests\Unit\Entity\User
 */
class RoleTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * Try to change role after user create
     *
     * @return void
     */
    public function testChange()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_USER]);

        self::assertFalse($user->isAdmin());

        $user->changeRole(User::ROLE_ADMIN);

        self::assertTrue($user->isAdmin());
    }

    /**
     * Try to assign one role twice
     *
     * @return void
     */
    public function testAlready()
    {
        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);

        $this->expectExceptionMessage('Role is already assigned.');

        $user->changeRole(User::ROLE_ADMIN);
    }
}
