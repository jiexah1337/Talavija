<div>
    <table class="table table-hover">
        <thead class="thead-transparent">
            <tr align="center">
                <?php if($canUpdate):?>
                    <th></th>
                <?php endif ?>
                <th>Amats</th>
                <th>No</th>
                <th>Līdz</th>
                <th>Atskaite</th>
            </tr>
        </thead>
        <tbody class="list" id="user-table-body" align="center">
            @foreach($roles_history as $role_history)
                @include('fragments.role-history', array('roleh' => $role_history))
            @endforeach
        </tbody>
    </table>
</div>