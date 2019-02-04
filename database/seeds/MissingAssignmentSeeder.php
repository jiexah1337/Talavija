<?php

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as Sentinel;

class MissingAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = Sentinel::getUserRepository()->get();

        try{
            $defaultRole = Sentinel::getRoleRepository()->findBySlug("z!");
            foreach ($users as $key=>$user){
                if(!$user->inRole($defaultRole)){
                    $defaultRole->users()->attach($user);
                }
            }
        } catch (\Exception $e) {

        }

    }
}
