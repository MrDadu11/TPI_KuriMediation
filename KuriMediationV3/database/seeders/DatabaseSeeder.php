<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Type;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public $types = ['Classe', 'Conflit Elèves', 'Conflit Enseignants', 'Classe', 'Financier', 'Harcèlement'];
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

        // Creates the list of basic categories
        foreach($this->types as $type){
            Type::factory()->create([
                'name' => $type
            ]);
        }

    }
}
