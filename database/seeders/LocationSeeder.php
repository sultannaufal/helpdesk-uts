<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
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
            'parent_id' => '0'
        ],
        [
            'id' => '2',
            'loc' => 'G. BNI',
            'parent_id' => '0'
        ],
        [
            'id' => '3',
            'loc' => 'G. BRI',
            'parent_id' => '0'
        ],
        [
            'id' => '4',
            'loc' => 'G. Newmont',
            'parent_id' => '0'
        ],
        [
            'id' => '5',
            'loc' => 'G. Dikti',
            'parent_id' => '0'
        ],
        [
            'id' => '6',
            'loc' => 'Lab. Elektro',
            'parent_id' => '0'
        ],
        [
            'id' => '7',
            'loc' => 'Lab. Biotek',
            'parent_id' => '0'
        ],
    //--------------------------------//
        [
            'id' => '8',
            'loc' => 'R.1',
            'parent_id' => '1'
        ],
        [
            'id' => '9',
            'loc' => 'R.2',
            'parent_id' => '1'
        ],
    //--------------------------------//
        [
            'id' => '10',
            'loc' => 'BNI.1',
            'parent_id' => '2'
        ],
        [
            'id' => '11',
            'loc' => 'BNI.2',
            'parent_id' => '2'
        ],
    //--------------------------------//
        [
            'id' => '12',
            'loc' => 'BRI.1',
            'parent_id' => '3'
        ],
        [
            'id' => '13',
            'loc' => 'BRI.1',
            'parent_id' => '3'
        ],
    //--------------------------------//
        [
            'id' => '14',
            'loc' => 'N.1',
            'parent_id' => '4'
        ],
        [
            'id' => '15',
            'loc' => 'N.2',
            'parent_id' => '4'
        ],
    //--------------------------------//
        [
            'id' => '16',
            'loc' => 'D.1',
            'parent_id' => '5'
        ],
        [
            'id' => '17',
            'loc' => 'D.2',
            'parent_id' => '5'
        ],
    //--------------------------------//
        [
            'id' => '18',
            'loc' => 'LE.1',
            'parent_id' => '6'
        ],
        [
            'id' => '19',
            'loc' => 'LE.2',
            'parent_id' => '6'
        ],
    //--------------------------------//
        [
            'id' => '20',
            'loc' => 'LB.1',
            'parent_id' => '7'
        ],
        [
            'id' => '21',
            'loc' => 'LB.2',
            'parent_id' => '7'
        ],
        ]);
    }
}
