<?php

namespace App\Mail\Auth;

use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class VerifyEmail
 *
 * @package App\Mail
 */
class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;


    /**
     * VerifyEmail constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return VerifyEmail
     */
    public function build()
    {
        return $this
            ->subject('Email Confirmation')
            ->markdown('emails.auth.verify');
    }
}
