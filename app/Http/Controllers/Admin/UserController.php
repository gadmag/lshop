<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    private $rules = [
        'username' => 'required|max:255',
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6',
    ];

    public function __construct(Request $request)
    {

    }


    public function index()
    {
        $users = User::all();
        return view('AdminLTE.user.index',['users' =>$users]);
    }

    public function create()
    {
        $roles = \App\Role::pluck('name', 'id');
        return view('AdminLTE.user.create',[
            'roles' => $roles
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = \App\Role::pluck('name', 'id');
        return view('AdminLTE.user.edit', [
            'user' => $user,
            'roles'=> $roles,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'block' => $request->block,
            'password' => bcrypt($request->password),
        ]);
        $this->syncRoles($user,$request->input('role_list')? : []);
//        $role = Role::where('name','Registered')->first();
//        $user->roles()->attach($role->id);
        return  redirect("admin/user")->with([
            'flash_message'               =>   "Пользователь {$user->username} добавлена",
//          'flash_message_important'     => true
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->rules);
        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'block' => $request->block,
            'password' => bcrypt($request->password),
        ]);
        $this->syncRoles($user,$request->input('role_list')? : []);
        return redirect("admin/user/")->with([
            'flash_message'               =>   "Пользователь обновлен",
//          'flash_message_important'     => true
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $username = $user->username;
        $user->delete();
        return redirect("admin/user")->with([
            'flash_message'               =>   "Пользователь {$username} удален",
//          'flash_message_important'     => true
        ]);
    }

    private function syncRoles(User $user, array $roles)
    {
        $user->roles()->sync($roles);
    }
}
