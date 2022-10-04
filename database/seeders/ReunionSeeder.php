<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReunionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asunto = [
            "1"=>"xd",
        ];

        DB::table('reunion')->insert([
            'id_creador ' => 1,
            'description' => 'Reunion de emergencia',
            'fecha_programada' => now(),
            'asuntos' => json_encode($asunto)
        ]);
    }
}
