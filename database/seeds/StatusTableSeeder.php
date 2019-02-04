<?php

use Illuminate\Database\Seeder;
use \Entities\Status as Status;
class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'z'  =>  [
                'title'              =>      'Zēns',
                'abbreviation'      =>      'z!',
                'default'           =>      true,
            ],

            'fil'  =>  [
                'title'              =>      'Filistrs',
                'abbreviation'      =>      'fil!',
                'default'           =>      false,
            ],

            'com'   =>  [
                'title'              =>      'Komiltons',
                'abbreviation'      =>      'com!',
                'default'           =>      false,
            ],

            'filb'  =>  [
                'title'              =>      'Filistrs Buršs',
                'abbreviation'      =>      'fil!b!',
                'default'           =>      false,
            ],

            'bfil'  =>  [
                'title'              =>      'Buršs Filistrs',
                'abbreviation'      =>      'b!fil!',
                'default'           =>      false,
            ],
        ];

        foreach($statuses as $key=>$status){
            if(!Status::where('abbreviation', $status['abbreviation'])->exists()){
                Status::create([
                    'title'          =>  $status['title'],
                    'abbreviation'  =>  $status['abbreviation'],
                    'default'       =>  $status['default'],
                ]);
            }
        }
    }
}
