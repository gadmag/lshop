<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(ArticleTypeSeeder::class);
        $this->call(ArticleTableSeeder::class);


    }
}
class UserTableSeeder extends DatabaseSeeder
{
    public function run()
    {
      // DB::table('users')->delete();

       $role_user = App\Role::where('name', 'Registered')->first();
       $role_author = App\Role::where('name', 'Moderator')->first();
       $role_admin = App\Role::where('name', 'Admin')->first();



        $user = new App\User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password  = bcrypt('159753');
        $user->save();
        $user->roles()->attach($role_admin);

        $user = new App\User();
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->password  = bcrypt('159753');
        $user->save();
        $user->roles()->attach($role_user);

        $author = new App\User();
        $author->name = 'Author';
        $author->email = 'author@gmail.com';
        $author->password  = bcrypt('159753');
        $author->save();
        $author->roles()->attach($role_author);


    }
}

class ArticleTypeSeeder extends DatabaseSeeder
{
    public function run()
    {
        DB::table('article_types')->delete();

        \App\ArticleType::create([

            'name' => 'news',
            'title' => 'Новость',

        ]);

        \App\ArticleType::create([

            'name' => 'photo',
            'title' => 'Слайдер',

        ]);

        \App\ArticleType::create([

            'name' => 'design',
            'title' => 'Дизайнерские идеи',

        ]);

    }
}
class TagTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        DB::table('tags')->delete();

        \App\Tag::create([
            'name' => 'personal',
        ]);
        \App\Tag::create([
            'name' => 'food',
        ]);
        \App\Tag::create([
            'name' => 'work',
        ]);
        \App\Tag::create([
            'name' => 'eat',
        ]);
    }
}
class ArticleTableSeeder extends  DatabaseSeeder
{
    public function run()
    {

        DB::table('articles')->delete();
        \App\Article::create([
            'title' => 'Новость 1',
            'body'  => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque fugit
                        itaque molestias, odit perspiciatis recusandae soluta tempore? Aut eos exercitationem itaque
                        laudantium maiores placeat repellat rerum ut velit, voluptas? Adipisci animi, at aut commodi, consequatur culpa
                         distinctio dolorem eligendi enim error fugit minus nesciunt obcaecati ratione repellendus suscipit totam veritatis?',
            'type' => 'news',
            'user_id' => 1,
            'status' => 1
        ]);

        \App\Article::create([
            'title' => 'Новость 2',
            'body'  => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque fugit
                        itaque molestias, odit perspiciatis recusandae soluta tempore? Aut eos exercitationem itaque
                        laudantium maiores placeat repellat rerum ut velit, voluptas? Adipisci animi, at aut commodi, consequatur culpa
                         distinctio dolorem eligendi enim error fugit minus nesciunt obcaecati ratione repellendus suscipit totam veritatis?',
            'type' => 'news',
            'user_id' => 1,
            'status' => 1
        ]);



    }

}

class MenuTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        DB::table('menu_link')->delete();

        \App\Menu::create([
            'link_title' => 'Главная',
            'link_path'  => '/',
            'menu_type' => 'main_menu',
            'status'    => 1,

        ]);
        \App\Menu::create([
            'link_title' => 'О нас',
            'link_path'  => 'about',
            'menu_type' => 'main_menu',
            'parent_id'  => 1,
            'status'    => 1
        ]);
        \App\Menu::create([
            'link_title' => 'Контакты',
            'link_path'  => 'contact',
            'menu_type' => 'main_menu',
            'parent_id'  => 2,
            'status'    => 1
        ]);
    }
}

class RoleTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        DB::table('roles')->delete();

        \App\Role::create([

            'name' => 'Registered',
//            'permissions' => [
//                'update-post' => true,
//                'create-post' => true,
//            ]

        ]);
        \App\Role::create([

            'name' => 'Moderator',
            'permissions' => [
                'update-post' => true,
                'create-post' => true,
            ]

        ]);
        \App\Role::create([

            'name' => 'Admin',

        ]);
    }
}

class ProductTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        \App\Product::create([
           'title' => "Кольцо",
           'description' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque fugit
                        itaque molestias, odit perspiciatis recusandae soluta tempore? Aut eos exercitationem itaque",
            'price' => 10,
            'status' => 1,
            'user_id' => 1,
        ]);
    }
}