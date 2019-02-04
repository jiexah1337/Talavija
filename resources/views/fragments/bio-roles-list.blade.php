
<div>
    <table class="table table-hover">
        <tbody class="list" id="user-table-body">
        @foreach($user->roles()->get() as $role)
            @include('fragments.bio-roles', array('test' => $user))
        @endforeach
        </tbody>
    </table>
</div>