<!--TODO: Filtering user list-->
<table class="table table-striped table-hover">
    <thead class="thead-dark">
    <tr>
        <th>Nr</th>
        <th>Statuss</th>
        <th>Vārds</th>
        <th>Uzvārds</th>
        <th>Telefons</th>
        <th>E-Pasts</th>
        <th>Dzīvesvieta</th>
        <th>Opcijas</th>
    </tr>
    </thead>
    <tbody class="list" id="user-table-body">
    @foreach($users as $user)
        <tr @if(isset($user->bio->deathdata->date)) class="text-muted" @endif>
            <td class="member_id">{{ $user->member_id }}</td>
            <td class="member_id">{{ $user->status()->abbreviation }}</td>
            <td class="name">{{ $user->name }}</td>
            <td class="surname">{{ $user->surname }}</td>
            <td class="phone-nr">{{$user->phone}}</td>
            <td class="email">{{ $user->email }}</td>
            <td class="location">
                <?php $loc = $user->lastResidenceAlt();
                if(isset($loc)) :?>
                {{$loc->location->country.', '.$loc->location->city.', '.$loc->location->address}}
                <?php endif;?>
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a type="button" class="btn btn-secondary" href="/bio/{{$user->member_id}}">Bio</a>
                    <a type="button" class="btn btn-secondary disabled">?</a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>