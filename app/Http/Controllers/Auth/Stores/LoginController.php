<?php

namespace App\Http\Controllers\Auth\Stores;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider as ProvidersRouteServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create() 
    {
        return view('auth.stores.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = Auth::guard('store')->attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        );

        if (!$result) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);

            $request->session()->regenerate();

        return redirect()->intended(ProvidersRouteServiceProvider::HOME);
        }
    }
}
