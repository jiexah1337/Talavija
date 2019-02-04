<?php

use Illuminate\Database\Seeder;
use Entities\User as User;

class BulkUserGenerator extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amount = 10;
        $id = 1;
        for($i = 1; $i <= $amount;){
            if(!User::where('member_id', $id)->exists()){
                $faker = Faker\Factory::create('lv_LV');
//                $faker = Faker\Factory::create('en_US');
                $name = $faker->firstName;
                $surname = $faker->lastName;
                $domain = $faker->freeEmailDomain;
                $credentials = [
                    'member_id'     =>  $id,
                    'name'          =>  $name,
                    'surname'       =>  $surname,
                    'email'         =>  $name.'.'.$surname.$id.'@'.$domain,
                    'phone'         =>  $faker->e164PhoneNumber,
                    'password'      =>  'generatedUser',
                ];
                Sentinel::registerAndActivate($credentials);
                $i++;
            } else {
                $id++;
            }
        }
    }
}
