<?php

namespace App\Http\Services\Auth;

use App\Entity\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;
use Illuminate\Events\Dispatcher as DispatcherInterface;

/**
 * Class RegisterService
 *
 * @package App\Http\Services\Auth
 */
class RegisterService
{

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;


    /**
     * RegisterService constructor.
     *
     * @param MailerInterface $mailer
     * @param DispatcherInterface $dispatcher
     *
     * @return void
     */
    public function __construct(MailerInterface $mailer, DispatcherInterface $dispatcher)
    {
        $this->mailer     = $mailer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param RegisterRequest $request
     *
     * @return void
     */
    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

        //$this->mailer->to($user->email)->send(new VerifyEmail($user));
        $this->dispatcher->dispatch(new Registered($user));
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function verify($token): void
    {
        $user = User::where('verify_token', $token)->first();

        if (null === $user) {
            throw new \DomainException('Your link cannot be identified.');
        }

        $user->verify();
    }
}
