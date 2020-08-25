<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'date_of_birth' => $faker->dateTimeBetween('1990-01-01', '2012-12-31')->format('Y/m/d'),
        'address' =>$faker->address,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'phone' => $faker->phoneNumber,
        'password' => '$2y$12$C2Zd3rGmINBs2AKLKiZYBeUPzipwkMj0mfFrCP3qP1ahdlQxnL3e6', // 1234
        'role' => 3,
        'remember_token' => Str::random(10),
        'deleted_at' => NULL,
    ];
});
