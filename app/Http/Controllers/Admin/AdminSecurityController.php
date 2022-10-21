<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSecurityController extends Controller
{
    private Request $request;
    private UserService $userService;

    public function __construct(Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    public function login()
    {
        $user = Auth::user();

        if (!empty($user)) {
            return redirect('/');
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $credentials = $this->request->validate($this->userService->loginFields);

            if (Auth::attempt($credentials)) {
                $this->request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }

            return back()->withErrors([
                'login' => 'Дані для входу невірні',
            ])->onlyInput('email');

        }

        return view('admin.security.login');
    }
}
