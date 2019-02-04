@foreach($users as $user)
    {{--<a href="#" class="list-group-item list-group-item-action {{$class}}" data-member="{{$user->member_id}}">--}}
        {{--{{$user->member_id}} - {{$user->name.' '.$user->surname}}--}}
    {{--</a>--}}

    <a href="#" class="list-group-item list-group-item-action {{$class}}" data-member="{{$user->name.' '.$user->surname.' ('.$user->member_id.')'}}">
        <div class="row">
            <div class="col-sm-1">
                <img src="/storage/avatars/thumbnails/{{md5($user->member_id)}}.png" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'" class="rounded-circle" style="width: 30px">
            </div>
            <div class="col-sm-2 text-center">
                    {{$user->member_id}}
            </div>
            <div class="col-sm-4">
                {{$user->name.' '.$user->surname}}
            </div>
        </div>

    </a>
@endforeach