<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\VerifyEmail;
use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(): string
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'         => $request['name'],
            'email'        => $request['email'],
            'password'     => Hash::make($request['password']),
            'verify_token' => Str::random(),
            'status'       => User::STATUS_WAIT,
        ]);

//        Mail::to($user->email)->send(new VerifyEmail($user));
        event(new Registered($user));

        return redirect()
            ->route('login')
            ->with('success', 'Check email and click on the link for verify');
    }

    /**
     * @param string $token
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(string $token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()
                ->route('login')
                ->with('error', 'Your link cannot be identified.');
        }

        if ($user->status === User::STATUS_ACTIVE) {
            return redirect()
                ->route('login')
                ->with('error', 'Your link cannot be identified.');
        }

        $user->status = User::STATUS_ACTIVE;
        $user->verify_token = null;

        $user->save();

        return redirect()
            ->route('login')
            ->with('success', 'Your email is verified.');
    }
}
