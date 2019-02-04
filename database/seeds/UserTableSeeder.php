<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as Sentinel;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ADMIN USER
        $credentials = [
            'member_id'     =>  0,
            'name'          =>  'Admin',
            'surname'       =>  'Admin',
            'email'         =>  'Admin@Talavija.lv',
            'phone'         =>  '+371 00000000',
            'password'      =>  '-!ADMIN!-',
        ];

        $admin = Sentinel::getUserRepository()->findByCredentials($credentials);
        $adminRole = Sentinel::getRoleRepository()->findBySlug('admin');

        if(!$admin){
            Sentinel::setModel('Entities\User');
            Sentinel::registerAndActivate($credentials);
        }
        try
        {
            $adminRole->users()->attach($admin);
        } catch (\Exception $e){

        }
    }
}
