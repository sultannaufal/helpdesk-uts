<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
        [
            'id' => '1',
            'loc' => 'Rektorat',
        ],
        [
            'id' => '2',
            'loc' => 'G. BNI',
        ],
        [
            'id' => '3',
            'loc' => 'G. BRI',
        ],
        [
            'id' => '4',
            'loc' => 'G. Newmont',
        ],
        [
            'id' => '5',
            'loc' => 'G. Dikti',
        ],
        [
            'id' => '6',
            'loc' => 'Lab. Elektro',
        ],
        [
            'id' => '7',
            'loc' => 'Lab. Biotek',
        ],
    //--------------------------------//
        [
            'id' => '8',
            'loc' => 'R.1',
        ],
        [
            'id' => '9',
            'loc' => 'R.2',
        ],
    //--------------------------------//
        [
            'id' => '10',
            'loc' => 'BNI.1',
        ],
        [
            'id' => '11',
            'loc' => 'BNI.2',
        ],
    //--------------------------------//
        [
            'id' => '12',
            'loc' => 'BRI.1',
        ],
        [
            'id' => '13',
            'loc' => 'BRI.1',
        ],
    //--------------------------------//
        [
            'id' => '14',
            'loc' => 'N.1',
        ],
        [
            'id' => '15',
            'loc' => 'N.2',
        ],
    //--------------------------------//
        [
            'id' => '16',
            'loc' => 'D.1',
        ],
        [
            'id' => '17',
            'loc' => 'D.2',
        ],
    //--------------------------------//
        [
            'id' => '18',
            'loc' => 'LE.1',
        ],
        [
            'id' => '19',
            'loc' => 'LE.2',
        ],
    //--------------------------------//
        [
            'id' => '20',
            'loc' => 'LB.1',
        ],
        [
            'id' => '21',
            'loc' => 'LB.2',
        ],
        ]);
    }
}
