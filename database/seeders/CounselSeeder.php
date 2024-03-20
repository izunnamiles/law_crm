<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('counsels')->insert([
            [
                'name' => 'Nduka Obi'
            ],
            [
                'name' => 'Abdul Wasiu'
            ],
            [
                'name' => 'Olueatobi Oke'
            ],
        ]);
    }
}
