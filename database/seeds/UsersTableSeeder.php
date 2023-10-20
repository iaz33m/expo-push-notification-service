<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $users = 10;

        $faker = Factory::create();

        for( $j = 1; $j<=$users; $j++ ) {

            $user = User::create([
                'name' => $faker->name,
                'avatar' => $faker->imageUrl($width = 150, $height = 150),
                'email' => ($j==1) ? "admin@admin.com": $faker->email,
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('123456'),
                'remember_token' => str_random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
           ]);

           $role = ($j==1) ? env('SUPER_ADMIN_ROLE_NAME','Admin'): null;
           $user->assignRole($role);
        }
    }
}
