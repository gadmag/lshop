<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'blocked' => 0,
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'quantity' => $faker->numberBetween(1, 100),
        'status' => 1,
        'model' => $faker->unique()->word,
        'sku' => $faker->unique()->word,
        'price' => $faker->numberBetween(50, 1000),
        'user_id' => 1
//        'user_id' => function () {
//            return factory(App\User::class)->create()->id;
//        }
    ];
});
$factory->define(App\Catalog::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text,
        'parent_id' => 1,
        'status' => 1,
        'order' => 0,
        'depth' => 0,
        'user_id' => 1

    ];
});

$factory->define(App\Special::class, function (Faker $faker) {
   return [
       'price' => $faker->numberBetween(50, 1000),
        'price_prefix' => '+',
        'priority' => 0,
       'date_start' => \Carbon\Carbon::now(),
       'date_end' => \Carbon\Carbon::now()->addDays(2),
   ];
});

$factory->define(App\Option::class, function (Faker $faker) {
   return [
       'price' => $faker->numberBetween(50, 1000),
        'color' => $faker->word,
        'color_stone' => $faker->word,
       'weight' => $faker->numberBetween(1,20),
       'quantity' => 2,
   ];
});
