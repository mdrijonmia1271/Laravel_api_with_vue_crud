<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name'=>'Rafi', 'email'=>'rafi@gmail.com', 'password'=>'123456'],
            ['name'=>'Mohosin', 'email'=>'mohosin@gmail.com', 'password'=>'654321'],
            ['name'=>'Habib', 'email'=>'habib@gmail.com', 'password'=>'asdf123']
        ];
        User::insert($users);
    }
}
