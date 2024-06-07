<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Type;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const TYPES = ['Conflit Elèves', 'Conflit Enseignants', 'Classe', 'Financier', 'Harcèlement'];
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'ETML1234',
            'isAdmin' => true,
        ]);
        User::factory()->create([
            'username' => 'user1',
            'firstname' => 'user1',
            'lastname' => 'user1',
            'email' => 'user1@user.com',
            'password' => 'ETML1234',
            'isAdmin' => false,
        ]);

        // Creates the list of basic categories
        foreach(self::TYPES as $type){
            Type::factory()->create([
                'name' => $type
            ]);
        }

    }
}
