<b>Tēvs:</b> {{$bio->father or '-'}}<br>
<b>Māte:</b> {{$bio->mother or '-'}}<br>

<?php $children = (array) $children?>
@if(count($children) > 0 && $children[0] != '')
<b>Pēcteči:</b> <br>
<ul>
    @foreach((array)$children as $child)
        <li>{{$child}}</li>
    @endforeach
</ul>
@endif

<?php $otherfam = (array) $otherfam?>
@if(count($otherfam) > 0 && $otherfam[0] != '')
    <b>Citi:</b> <br>
    <ul>
        @foreach($otherfam as $fam)
            <li>{{$fam}}</li>
        @endforeach
    </ul>
@endif
