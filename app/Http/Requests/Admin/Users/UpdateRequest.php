<?php

namespace App\Http\Requests\Admin\Users;

use App\Entity\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateRequest
 *
 * @package App\Http\Requests\Admin\Users
 */
class UpdateRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'status'   => ['required', 'string', Rule::in([User::STATUS_WAIT, User::STATUS_ACTIVE])],
            'role'     => ['required', 'string', Rule::in([User::ROLE_USER, User::ROLE_ADMIN])]
        ];
    }
}
