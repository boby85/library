<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

    	for($i = 0; $i < 5; $i++) {
        	App\User::create([
            	'name' => $faker->name,
            	'date_of_birth' => $faker->date_of_birth,
            	'address' =>$faker->address,
            	'email' => $faker->email,
            	'email_verified_at' => $faker->email_verified_at,
            	'phone' => $faker->phone,
            	'password' =>$faker->password,
            	'role' => $faker->role,
            	'remember_token' => $faker->remember_token,
            	'deleted_at' => $faker->deleted_at,	
        	]);
    }
    }
}
