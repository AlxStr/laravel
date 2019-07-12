@component('mail::message')
    # Email Confirmation

    Please refer the following link:

    @component('mail::button', ['url' => route('register.verify', (string) $user->verify_token)])
        Verify Email
    @endcomponent

    Thanks, <br>
    {{ config('app.name') }}
@endcomponent

