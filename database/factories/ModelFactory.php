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

use App\Catalog;
use App\Discount;
use App\Option;
use App\Product;
use App\Special;
use App\User;
use Carbon\Carbon;
use App\Coupon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'blocked' => 0,
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'quantity' => $faker->numberBetween(1, 100),
        'status' => 1,
        'model' => $faker->unique()->word,
        'sku' => $faker->unique()->word,
        'price' => $faker->numberBetween(50, 1000),
        'user_id' => 1
    ];
});
$factory->define(Catalog::class, function (Faker $faker) {
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

$factory->define(Special::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(50, 1000),
        'price_prefix' => '+',
        'priority' => 0,
        'date_start' => \Carbon\Carbon::now(),
        'date_end' => \Carbon\Carbon::now()->addDays(2),
    ];
});

$factory->define(Option::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(50, 1000),
        'color' => $faker->word,
        'color_stone' => $faker->word,
        'weight' => $faker->numberBetween(1, 20),
        'quantity' => 2,
    ];
});

$factory->define(Discount::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(50, 1000),
        'quantity' => 10,
        'price_prefix' => '+',
        'date_start' => Carbon::now(),
        'date_end' => Carbon::now(),
    ];
});

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->word,
        'discount' => $faker->randomFloat(2),
        'uses_total' => $faker->randomNumber(2),
        'status' => 1,
        'date_start' => Carbon::now(),
        'date_end' => Carbon::now()->addDay(),
    ];
});
