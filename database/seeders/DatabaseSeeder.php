<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Listing;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $user = \App\Models\User::factory(5)->create();
        $user = User::factory()->create([
            "email" => "jhon@mail.com",
            "name" => "jhon doe"
        ]);
        Listing::factory(6)->create([
            "user_id" => $user->id
        ]);

        // foreach($listings as $listing)
        // {
        //     $listing->attach($user);
        // }
    }
}
