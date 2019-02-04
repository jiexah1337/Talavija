<div class="user-widget">
    <div class="user-image hidden-xs">
        <?php

        $repss = \Entities\Repatriation::get()->groupBy('member_id');
        foreach ($repss as $key=>$member_id){
            $bilance=0;
            foreach ($member_id as $id){
                $bilance+=$id->collected-$id->amount;
            }
            $member_id->total_balance=$bilance;

        }
        $member_id = Sentinel::getUser()->member_id;
        ;?>
        <img src="/storage/avatars/{{md5($member_id)}}.png" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">

    </div>
    <div class="user-data">
        <div><strong>{{$user->name}}</strong> {{$user->surname}}</div>
        <div>{{$user->email}}</div>
        <div>Reparticijas: <strong class="money-style-good">&euro;

                @if(isset($repss[$member_id]))
                    {{$repss[$member_id]->total_balance}}
                @endif</strong></div>

    </div>
</div>