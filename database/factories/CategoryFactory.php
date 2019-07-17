<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->city,
        'description' => $faker->text,
    ];
});
