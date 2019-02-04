@foreach($user->roles()->get() as $role)
    {{$role->name}} <br>
@endforeach