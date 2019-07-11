<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Auth\RegisterService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var RegisterService
     */
    private $registerService;

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
    public function __construct(RegisterService $service)
    {
        $this->middleware('guest');
        $this->registerService = $service;
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
        $this->registerService->register($request);

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
        try {
            $this->registerService->verify($token);

            return redirect()
                ->route('login')
                ->with('success', 'Your email is verified.');

        } catch (\DomainException $e) {

            return redirect()
                ->route('login')
                ->with('error', 'Your link cannot be identified.');
        }
    }
}
