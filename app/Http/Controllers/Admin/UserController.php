<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;

class UserController extends Controller
{



    public function index()
    {
        $users = User::all();
        return view('AdminLTE.user.index', ['users' => $users]);
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $roles = Role::pluck('name', 'id');
        return view('AdminLTE.user.create', [
            'roles' => $roles
        ]);
    }

    public function edit($id)
    {
        $this->authorize('edit', User::class);
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        return view('AdminLTE.user.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'blocked' => $request->blocked,
            'password' => bcrypt($request->password),
        ]);
        $this->authorize('store', $user);
        $role = Role::findOrFail($request->roles);
        $user->roles()->attach($role->id);
        return redirect("admin/users")->with([
            'flash_message' => "Пользователь {$user->username} добавлена",
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([

            'name' => $request->name,
            'email' => $request->email,
            'blocked' => $request->blocked,
            'password' => bcrypt($request->password),
        ]);
        $user->roles()->detach();
        $user->roles()->attach($request->roles);
        return redirect("admin/users")->with([
            'flash_message' => "Пользователь {$user->name} обновлен",
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $username = $user->name;
        $user->delete();
        return redirect("admin/users")->with([
            'flash_message' => "Пользователь {$username} удален",
        ]);
    }

    private function syncRoles(User $user, array $roles)
    {
        $user->roles()->sync($roles);
    }
}
