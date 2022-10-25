<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'nombre' => 'John Yulber',
            'apellido' => 'Inga Lapa',
            'dni' => '72843884'
        ])->create();

        $admin = User::factory([
            'nombre' => 'Ricardo',
            'apellido' => 'Huamanrimachi Espinoza',
            'dni' => '07991231',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Roger Rogelio',
            'apellido' => 'Alacuti De la cruz',
            'dni' => '45075793',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Jose',
            'apellido' => 'Mundo Unocc',
            'dni' => '16176861',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Jesus',
            'apellido' => 'Agüero Vega',
            'dni' => '04041062',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Victor',
            'apellido' => 'Chancavilca Matos',
            'dni' => '10597686',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Francisco',
            'apellido' => 'Gomez Solano',
            'dni' => '23714606',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Valentin',
            'apellido' => 'Romero Borrena',
            'dni' => '23672319',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Andres Avelino',
            'apellido' => 'Peña Laban',
            'dni' => '16177198',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Delson Angel',
            'apellido' => 'De la cruz Mesa',
            'dni' => '80029848',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Fabian',
            'apellido' => 'Abregu Aguilar',
            'dni' => '46394040',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Oswaldo',
            'apellido' => 'Sinche Flores',
            'dni' => '16177276',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Leoncio',
            'apellido' => 'Cuadros Alarcon',
            'dni' => '16176864',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Valentin',
            'apellido' => 'Quispe Barrientos',
            'dni' => '09844008',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Raul',
            'apellido' => 'Sedano Lazaro',
            'dni' => '40180512',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Humberto',
            'apellido' => 'Arteaga Herrera',
            'dni' => '41156011',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Telio',
            'apellido' => 'Veramendi Hurtado',
            'dni' => '20740677',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Rolando',
            'apellido' => 'Gala Sedano',
            'dni' => '44422542',
        ])->create();

        $admin = User::factory([
            'nombre' => 'Manuel Charlis',
            'apellido' => 'Ramos Gomez',
            'dni' => '43598455',
        ])->create();

    }
}
