<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        $admin = User::create([
            'name' => 'bilalkhan',
            'email' => 'bilalkhan@gmail.com',
            'password' => bcrypt('secret'),
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin->assignRole($adminRole);
    }
}
