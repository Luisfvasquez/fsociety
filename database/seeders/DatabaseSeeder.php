<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    protected static ?string $password;

    public function run(): void
    {
        // User::factory(10)->create();

        // Create roles
        Role::factory(2)->create();

        // Create a default user
        User::factory()->createOne([
            'name' => 'Luis',
            'last_name' => 'Vasquez',
            'email' => 'example@gmail.com',
            'phone_number' => '04145018145',
            'role_id' => 1,
            'password' => static::$password ??= Hash::make('12346789'), // hashed password for 'password'
            'remember_token' => null,        
        ]);
        
        // Create additional users
        User::factory(10)->create();
        
        // Create clients
        Client::factory(10)->create();
        
        // Create suppliers
        Supplier::factory(10)->create();

        // Create categories
        Category::factory(10)->create();
        
        $this->call(ProductSeeder::class);
    }
}
