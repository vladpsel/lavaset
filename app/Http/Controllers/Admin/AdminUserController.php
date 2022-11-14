<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function index(): View|Factory|Application|RedirectResponse
    {
        $me = Auth::user();
        $user = new User();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $rules = $user->getRules();
            $rules['phone'] = 'present';
            $rules['role'] = 'present';

            $validated = $this->request->validate($rules);

            $user = $user->create($validated);
            $data = [
                'user_id' => $user->id,
                'role' => $validated['role'],
            ];
            $userRole = UserRoles::create($data);
            return redirect()->route('admin.users');
        }

        return view('admin.users.index', [
            'items' => User::where('id', '!=', $me->id)->get(),
            'roles' => $user->allowedRoles,
            'password' => Str::random(10),
        ]);
    }

    public function update(int $id)
    {
        $me = Auth::user();
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.users');
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validated = $this->request->validate([
                'name' => 'required|min:2',
                'email' => 'required|unique:users,email,' . $user->id,
                'phone' => 'present',
                'role' => 'present',
            ]);

            $user->update($validated);
            $userRole = $user->role();
            $userRole->update(['role' => $validated['role']]);

            return redirect()->route('admin.users.single', $user->id);
       }

        return view('admin.users.update', [
            'user' => $user,
            'items' => User::where('id', '!=', $me->id)->get(),
            'roles' => $user->allowedRoles,
        ]);
    }

    public function delete(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.users');
        }

        $me = Auth::user();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $user->delete();
            return redirect()->route('admin.users');
        }

        return view('admin.users.delete', [
            'items' => User::where('id', '!=', $me->id)->get(),
            'user' => $user,
        ]);
    }


}
