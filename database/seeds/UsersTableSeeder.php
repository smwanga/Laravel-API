<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function ($user) {
            factory(App\ApiToken::class, 3)->make()->each(function ($key) use ($user) {
                $user->apiKeys()->save($key);
            });
        });
    }
}
