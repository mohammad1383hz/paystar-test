<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('edit', compact('user'));
    }
    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => 'required|confirmed|min:6',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request['password']);
        $user->save();
        return redirect()->route('index.product');
    }
}
