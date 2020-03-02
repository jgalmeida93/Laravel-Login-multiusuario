<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    public function login(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = [
            'user' => $request->email,
            'password' => $request->password
        ];

        $authOk = Auth::guard('admin')->attempt($credentials, $request->remember);

        if ($authOk) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function index() {
        return view('auth.admin-login');
    }
}
