<?php

use Illuminate\Database\Seeder;
use Entities\User as User;
use Carbon\Carbon as Carbon;
use Entities\Repatriation as Repatriation;
class RepatriationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Repatriation::count() < 100){
            $userIds = User::pluck('member_id')->toArray();

            $minYear = 2010;
            $maxYear = \Carbon\Carbon::today()->year;

            $min = -20;
            $max = 20;

            foreach ($userIds as $key=>$user){
                for($year = $minYear; $year <= $maxYear; $year++){
                    for($month = 1; $month <= 12; $month++){
                        $times = rand(0,5);
                        for($time = 1; $time <= $times; $time++){
                            $rep = new \Entities\Repatriation();
                            $rep->year = $year;
                            $rep->month = $month;

                            $rep->amount = mt_rand ($min*10, $max*10) / 10;
                            $rep->member_id = $user;
                            $rep->title = 'Seed Generated Value For Testing';
                            $rep->type = 'Cits';
                            $rep->issue_date = Carbon::now();
                            $rep->paid_date = Carbon::now();
                            $rep->collected = mt_rand (0, $max*10) / 10;
                            $rep->save();
                        }
                    }
                }
            }
        }

    }
}
