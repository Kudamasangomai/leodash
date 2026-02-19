<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Users/users', [
            'users' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return back()->with('success', 'User created Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {


        $user  = User::findOrFail($user->id);
        $validated = $request->validated();

        if (!empty($validated['password'])) {

            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['role'] = $request->input('role');
        $user->update($validated);
       return back()->with('success', 'User Upadated Successfully');
    }

}
