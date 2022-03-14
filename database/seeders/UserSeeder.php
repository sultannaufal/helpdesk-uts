<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(User::class, 20)->create();
        //factory(User::class, 2)->create(['role' => User::ROLE_MANAGER]);
        DB::table('users')->insert([
            'id' => '1',
            'name' => 'Sultan Naufal Abdillah',
            'email' => 'sultannaufal8158@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'manager',
        ],
        [
            'id' => '2',
            'name' => 'Nurhidayah',
            'email' => 'sultannaufal8158@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'client',
        ]
        );

    }
}
