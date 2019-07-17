<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) use ($factory) {
    return [
        'id' => $faker->unique()->randomNumber(),
        'name' => $faker->city,
        'description' => $faker->text,
        'price' => rand(500, 8000),
        'category_id' => $factory->create(Category::class)->id
    ];
});
