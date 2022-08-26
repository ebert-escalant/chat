<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::create([
            'name' => 'Ebert Escalante',
            'email' => 'ebertescalant@gmail.com',
            'password'=>bcrypt('123456789')
        ]);
        \App\Models\User::factory(10)->create();

        
    }
}
