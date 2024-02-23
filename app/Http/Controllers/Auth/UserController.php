<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (Auth::attempt($credentials)) {
                return redirect()->route('home');
            } else {
                return redirect()->back()->withErrors(['error' => 'Email or password incorrect.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Login error try again ' . $e->getMessage()]);
        }
    }

    public function signupForm()
    {
        return view('auth.signup');
    }

    public function signup(CreateUserRequest $request)
    {
        try {
            $credentials = $request->validated();

            $user = new User([
                ...$credentials,
                'password' => bcrypt($credentials['password'])
            ]);

            $user->save();

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Register error ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
