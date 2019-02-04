<div>
    @foreach($roles as $role)
        <div class="info-line">
            <div class="pull-left">
                {{$role->name}}
            </div>

            <div class="pull-right">
                {{$role->slug}}
            </div>
        </div>
    @endforeach
</div>