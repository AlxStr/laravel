<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers\Admin
 */
class UsersController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'status'   => User::STATUS_ACTIVE,
        ]);

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $statuses = [
            User::STATUS_WAIT   => 'Wait',
            User::STATUS_ACTIVE => 'Active',
        ];


        return view('admin.users.edit', compact('user', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User  $user
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'status'   => ['required', 'string', Rule::in([User::STATUS_WAIT, User::STATUS_ACTIVE])]
        ]);

        $user->update($data);

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
