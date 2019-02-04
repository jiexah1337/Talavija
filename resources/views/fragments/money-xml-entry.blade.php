<div class="card">
    <div class="card-header bg-primary">
        {{$entry['Type']}} - {{$entry['Details']['Debtor/Creditor']['Name'] or '?'}} -
        {{$entry['Details']['Debtor/Creditor']['Id']}} <br>
    </div>
    <div class="card-body">
        <b>IBAN: </b> <span class="privacy-control">{{$entry['Details']['Debtor/Creditor']['IBAN'] }} <br>
        <b>Summa: </b> &euro; {{$entry['Amount']}} <br>
        <b>Statuss: </b> {{$entry['Status']}}
        <hr>
        <b>Pierakstīšanas datums: </b>{{$entry['Booking Date']}}<br>
        <b>Apstiprinājuma datums: </b>{{$entry['Validation Date']}}<br>
    </div>
</div>
<hr>
<?php

?>