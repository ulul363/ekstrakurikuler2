<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticated(Request $request, $user)
{
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.page');
    }

    return redirect()->route('user.page');
}
}
