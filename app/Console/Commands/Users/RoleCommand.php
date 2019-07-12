<?php

namespace App\Console\Commands\Users;

use App\Entity\User;
use Illuminate\Console\Command;

/**
 * Class RoleCommand
 *
 * @package App\Console\Commands\Users
 */
class RoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return boolean
     */
    public function handle(): bool
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('Undefined user with that email.');
            return false;
        }

        try {
            $user->changeRole($role);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('Role is successfully assigned.');
        return true;
    }
}
