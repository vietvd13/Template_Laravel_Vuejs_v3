<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::find(1)) {
            User::insert([
                'id' => 1,
                'email' => 'test@gmail.com',
                'phone' => '0123456789',
                'password' => Hash::make('123456'),
                'name' => 'Nguyễn Mộng Tét',
            ]);
        }
    }
}
