<?php

use Illuminate\Database\Seeder;

use App\Role;
use App\Permission;
use App\User;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
        $this->createPermissions();

        $moderator = Role::where('slug','moderator')->first();
        $registered = Role::where('slug', 'registered')->first();
        $createPosts = Permission::where('slug','create-posts')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();

        //moderator
        $user1 = new User();
        $user1->name = 'moderator';
        $user1->email = 'moderator@mail.ru';
        $user1->password = bcrypt('secret');
        $user1->save();
        $user1->roles()->attach($moderator);
        $user1->permissions()->attach($createPosts);

        //registered
        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->save();
        $user2->roles()->attach($registered);
//        $user2->permissions()->attach($manageUsers);
    }

    public function createRoles()
    {
        Permission::create([
            'name' => 'Создавать посты',
            'slug' => 'create-posts',
        ]);

        Permission::create([
            'name' => 'Управлять пользователями',
            'slug' => 'manage-users',
        ]);
    }

    public function createPermissions()
    {
        Role::create([
            'name' => 'Модератор',
            'slug' => 'moderator',
        ]);

        Role::create([
            'name' => 'Зарегистрирован',
            'slug' => 'registered',
        ]);
        Role::create([
            'name' => 'Админ',
            'slug' => 'admin',
        ]);
    }
}
