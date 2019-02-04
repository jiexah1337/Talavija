<?php

use Illuminate\Database\Seeder;
use Entities\News as News;
use Entities\User as User;
class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            1 => 'info',
            2 => 'warning',
            3 => 'danger',
            4 => 'default',
            5 => 'brand'
        ];

        $titles = [
            1 => 'This is a XXXX type message',
            2 => 'Message of the type XXXX',
            3 => 'I am YYYY and I have this to say...',
            4 => 'I am YYYY and i have this XXXX message to post',
        ];

        $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis risus imperdiet, hendrerit nulla eu, tincidunt leo. Cras ac felis tincidunt, pretium magna eu, luctus eros. Donec accumsan porta libero, a consequat erat hendrerit id. Vivamus ut blandit lacus. Nulla ante nulla, tempor eu eros et, dapibus mattis metus. Suspendisse consequat ex id iaculis tristique. Donec vitae arcu porttitor, pretium sapien vel, porta lectus. Aliquam eleifend sem eu lorem pharetra, sed sollicitudin lacus sodales. Mauris eu magna eu nisl varius fermentum ac eu tellus. ';
        $userCount = User::count();
        for ($i = 0; $i <= 100; $i++){
            $r = rand(1, sizeof($types));
            $t = rand(1, sizeof($titles));
            $u = rand(1, $userCount-1);


            News::create([
                'title' => str_replace('YYYY', User::where('id', $u)->pluck('name')->first(),str_replace('XXXX', $types[$r],$titles[$t])),
                'content' => str_repeat($content, rand(1,20)),
                'type' => $types[$r],
                'member_id' => User::where('id', $u)->pluck('member_id')->first(),
                'post_date' => \Carbon\Carbon::now()->format('Y-m-d'),
            ]);
        }
    }
}
