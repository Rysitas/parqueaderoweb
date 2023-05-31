<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; use Illuminate\Support\Facades\Hash;

class TodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $useradmin=User::create([ 'name' => 'admin paul', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin'), 'tipo' => '1', ]);

        $user1=User::create([ 'name' => 'usuario Marcos', 'email' => 'user@gmail.com', 'password' => Hash::make('admin'), 'tipo' => '2', ]);
    }
}
