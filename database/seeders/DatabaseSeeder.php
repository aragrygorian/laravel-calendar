<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        if (! Role::where('name', 'admin')->first()) {
            $role = Role::create(['name' => 'admin']);
        }

        if (! Role::where('name', 'user')->first()) {
            $role = Role::create(['name' => 'user']);
        }

        
        if (! User::where('email', 'admin@gmail.com')->first()) {
            $admin = User::create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456')
            ]);
    
            $admin->assignRole('admin');
        }
    }
}
