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
        User::create([
            'name'       => 'Sara',
            // 'last_name'        => 'Mohammad',
            'email'            => 'user@gmail.com',
            'password'         => bcrypt('password'),
            // 'mobile_number'    => '0912346789',
        ]);
    }
}
