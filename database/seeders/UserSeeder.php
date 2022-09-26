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
        $admin = User::factory([
            'username' => 'admin',
            'nombre' => 'John Yulber',
            'apellido' => 'Inga Lapa',
            'dni' => '72843884'
        ])->create();
    }
}
