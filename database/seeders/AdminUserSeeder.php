<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
        ]);
        $user->assignRole('user', 'admin');

        $user2 = User::create([
            'name' => 'Admin User',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('adminadmin'),
        ]);
        $user2->assignRole('user', 'admin', 'super-admin');
    }
}
