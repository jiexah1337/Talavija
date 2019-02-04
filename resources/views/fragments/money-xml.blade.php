<div class="card">
    <div class="card-header">
        <b>Ziņas ID: </b>{{$xmlOutput['Group Header']['Message Id']}} - <b>Izveidots: </b> {{$xmlOutput['Group Header']['Created Date']}}<br>
        <hr>
        <b>ID: </b>{{$xmlOutput['Statement']['Id']}} -
        <b>Elektroniskās sekvences numurs: </b>{{$xmlOutput['Statement']['Electronic Sequential Number']}} -
        <b>Izveidots: </b>{{$xmlOutput['Statement']['Created']}} <br>
        <hr>
        <b>No: </b>{{$xmlOutput['Statement']['From Date']}} -
        <b>Līdz: </b>{{$xmlOutput['Statement']['To Date']}}
    </div>
    <div class="card-header bg-dark text-light">
        <b>Konta Nr: </b>
        {{$xmlOutput['Benefactory']['IBAN']}} -
        <div>
            <b>Konta īpašnieks: </b>
            {{$xmlOutput['Benefactory']['Owner']['Name']}} <br>
            {{$xmlOutput['Benefactory']['Owner']['Country']}}
            {{$xmlOutput['Benefactory']['Owner']['Address']}} <br>
            {{$xmlOutput['Benefactory']['Owner']['Id']}} <br>
        </div>
    </div>
    <div class="card-body">
        @foreach($xmlOutput['Entries'] as $key=>$entry)

            @include('fragments.money-xml-entry', compact([$entry]))

        @endforeach
    </div>
</div>