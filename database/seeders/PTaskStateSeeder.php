<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PTaskStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'status'=>0,
                "entitled"=>'En attente'
            ],
            [
                'status'=>1,
                "entitled"=>'En cours'
            ],
            [
                'status'=>2,
                "entitled"=>'Terminé'
            ],
        ];
        DB::table('p_task_states')->insert($data);
    }
}
