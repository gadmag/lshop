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
        $this->call(StatusTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(PaymentTableSeeder::class);
        $this->call(ShipmentTableSeeder::class);

    }
}


class UserTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        $role_admin = App\Role::where('slug', 'admin')->first();

        $user = new App\User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('159753');
        $user->blocked = 0;
        $user->save();
        $user->roles()->attach($role_admin);
    }
}

class PageTableSeeder extends DatabaseSeeder
{
    public function run()
    {

        \App\Page::create([
            'title' => 'Главная страница',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque fugit
                        itaque molestias, odit perspiciatis recusandae soluta tempore? Aut eos exercitationem itaque
                        laudantium maiores placeat repellat rerum ut velit, voluptas? Adipisci animi, at aut commodi, consequatur culpa
                         distinctio dolorem eligendi enim error fugit minus nesciunt obcaecati ratione repellendus suscipit totam veritatis?',
            'alias' => 'front',
            'user_id' => 1,
            'status' => 1
        ]);


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

class ArticleTableSeeder extends DatabaseSeeder
{
    public function run()
    {

        DB::table('articles')->delete();
        \App\Article::create([
            'title' => 'Новость 1',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque fugit
                        itaque molestias, odit perspiciatis recusandae soluta tempore? Aut eos exercitationem itaque
                        laudantium maiores placeat repellat rerum ut velit, voluptas? Adipisci animi, at aut commodi, consequatur culpa
                         distinctio dolorem eligendi enim error fugit minus nesciunt obcaecati ratione repellendus suscipit totam veritatis?',
            'type' => 'photo',
            'user_id' => 1,
            'status' => 1
        ]);

        \App\Article::create([
            'title' => 'Новость 2',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque fugit
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
            'link_title' => 'Фурнитура',
            'link_path' => '#',
            'menu_type' => 'main_menu',
            'status' => 1,

        ]);
        \App\Menu::create([
            'link_title' => 'Серебро 925',
            'link_path' => '#',
            'menu_type' => 'main_menu',
            'status' => 1,

        ]);
        \App\Menu::create([
            'link_title' => 'Кристаллы',
            'link_path' => '#',
            'menu_type' => 'main_menu',
            'status' => 1,

        ]);
        \App\Menu::create([
            'link_title' => 'Камни',
            'link_path' => '#',
            'menu_type' => 'main_menu',
            'status' => 1,

        ]);
        \App\Menu::create([
            'link_title' => 'Упаковка',
            'link_path' => '#',
            'menu_type' => 'main_menu',
            'status' => 1,

        ]);
        \App\Menu::create([
            'link_title' => 'О нас',
            'link_path' => 'about',
            'menu_type' => 'main_menu',
            'parent_id' => 0,
            'status' => 1
        ]);
        \App\Menu::create([
            'link_title' => 'Контакты',
            'link_path' => 'contact',
            'menu_type' => 'main_menu',
            'parent_id' => 0,
            'status' => 1
        ]);
    }
}

class RoleTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        DB::table('roles')->delete();

        \App\Role::create([

            'name' => 'Зарегистрирован',
            'slug' => 'registered'

        ]);
        \App\Role::create([

            'name' => 'Модератор',
            'slug' => 'moderator'


        ]);
        \App\Role::create([
            'name' => 'Администратор',
            'slug' => 'admin'
        ]);
    }
}

class ProductTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        factory(\App\Product::class, 40)->create();

    }
}

class StatusTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        \App\OrderStatus::create([
            'name' => "Ожидание",
            'is_default' => 1,
        ]);
        \App\OrderStatus::create([
            'name' => "В обработке",
        ]);
        \App\OrderStatus::create([
            'name' => "Доставлено",
        ]);
        \App\OrderStatus::create([
            'name' => "Выслан",
        ]);
        \App\OrderStatus::create([
            'name' => "Отменено",
        ]);
        \App\OrderStatus::create([
            'name' => "	Сделка завершена",
        ]);
    }
}

class PaymentTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        \App\Payment::create([
            'title' => "Банковская карта",
            'name' => "credit_card",
            'payment_key' => "5469600025133406 Амина Байсолтановна",
            'status' => 1,
            'order' => 0,
        ]);
        \App\Payment::create([
            'title' => "QIWI Кошелек",
            'name' => "qiwi",
            'payment_key' => "89285109392",
            'status' => 1,
            'order' => 1,
        ]);
        \App\Payment::create([
            'title' => "Яндекс Кошелек",
            'name' => "yandex",
            'payment_key' => "c193847",
            'status' => 1,
            'order' => 2,
        ]);
        \App\Payment::create([
            'title' => "Paypal Кошелек",
            'name' => "paypal",
            'payment_key' => "c193847",
            'status' => 1,
            'order' => 3,
        ]);
        \App\Payment::create([
            'title' => "Оплата при получении",
            'name' => "cash",
            'payment_key' => "cash",
            'status' => 1,
            'order' => 4,
        ]);

    }
}
class ShipmentTableSeeder extends DatabaseSeeder
{
    public function run()
    {
        \App\Payment::create([
            'title' => "Доставка почтой по России",
            'name' => "pochta_ru",
            'price_setting' => "",
            'status' => 1,
            'order' => 0,
        ]);


    }
}