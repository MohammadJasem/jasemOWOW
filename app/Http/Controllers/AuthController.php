<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login () {
        if (auth('sanctum')->check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function register () {
        if (auth('sanctum')->check()) {
            return redirect('/');
        }
        return view('auth.register');
    }
}
