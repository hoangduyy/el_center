<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        // @todo
//        if (backendIsLogin()) {
//            return redirect()->route(backendRouterName('dashboard'));
//        }

        return view('backend.auth.login');
    }

    public function showFormLoginTeacher()
    {
        return view('teacher.auth.login');
    }

    public function postLogin()
    {
        if (beGuard()->attempt(request()->only('email', 'password'))) {
            return redirect()->route('be.dashboard');
        }

        return redirect()->back()->withErrors('Email hoặc Password không chính xác')->withInput(request()->all());
    }

    public function postLoginTeacher()
    {
        if (tGuard()->attempt(request()->only('email', 'password'))) {
            return redirect()->route('t.profile');
        }

        return redirect()->back()->withErrors('Email hoặc Password không chính xác')->withInput(request()->all());
    }

    public function logout()
    {
        beGuard()->logout();
        return redirect()->route('be.login');
    }

    public function logoutTeacher()
    {
        tGuard()->logout();
        return redirect()->route('t.login');
    }
}
