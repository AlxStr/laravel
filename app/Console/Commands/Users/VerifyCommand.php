<?php

namespace App\Console\Commands\Users;

use App\Entity\User;
use App\Http\Services\Auth\RegisterService;
use Illuminate\Console\Command;

/**
 * Class VerifyCommand
 *
 * @package App\Console\Commands\Users
 */
class VerifyCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify user';

    /**
     * @var RegisterService
     */
    private $registerService;


    /**
     * VerifyCommand constructor.
     */
    public function __construct(RegisterService $service)
    {
        $this->registerService = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        try {
            $this->registerService->verify($user->verify_token);
            $this->info('User ' . $user->name .' with email ' . $email . ' verified successfully.');

            return true;

        } catch (\Throwable $e) {

            $this->error($e->getMessage());

            return false;
        }
    }
}
