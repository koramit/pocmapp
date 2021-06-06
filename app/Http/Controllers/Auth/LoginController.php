<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function __invoke()
    {
        Session::put('intended_url', URL::previous());

        return redirect('http://pocsso.test/login?redirectAfterAuthenticated='.urlencode(url('/')));
    }
}
