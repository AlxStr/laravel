<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Entity\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{

    use ThrottlesLogins;

    /**
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(): string
    {
        return view('auth.login');
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return 'email';
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $auth = Auth::attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($auth) {
            /** Присвоение сессии нового идентификатора */
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);
            $user = Auth::user();

            if ($user->status !== User::STATUS_ACTIVE) {
                Auth::logout();
                return back()->with('error', 'Account not confirmed, check mail');
            }

            return redirect()->intended(route('cabinet'));
        }

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['email' => trans('auth.failed')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }
}
