<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SSOAuthenticatedSessinController extends Controller
{
    public function create(Request $request)
    {
        if ($request->header('token') !== env('SSO_TOKEN')) {
            abort(401);
        }

        if (! $user = User::whereLogin($request->user['login'])->first()) {
            $user = new User();
            $user->name = $request->user['name'];
            $user->login = $request->user['login'];
            $user->password = Hash::make(Str::random(12));
            $user->save();
        }

        $url = URL::temporarySignedRoute('sso', now()->addSeconds(15), ['user' => $user->id]);

        return [
            'redirect' => $url,
        ];
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }

    public function store(User $user)
    {
        Auth::login($user);

        return redirect('dashboard');
    }
}
