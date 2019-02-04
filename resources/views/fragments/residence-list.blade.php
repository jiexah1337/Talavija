@foreach($residences['active'] as $residence)
    @include('fragments.residence', array('residence' => $residence, 'canUpdate' => $canUpdate))
@endforeach

@if(count($residences['inactive']) > 0)
<div class="card collapse-btn">
    <a href="#" data-toggle="collapse" data-target="#inactiveResidences" class="collapsed text-primary">
        <div class="card-header bg-light text-center">

            <span class="if-not-collapsed">
                <i class="fas fa-angle-double-up"></i>
            </span>
            <span class="if-collapsed">
                <i class="fas fa-angle-double-down"></i>
            </span>


        </div>
    </a>
</div>
@endif

<div id="inactiveResidences" class="inactive-style collapse">
    @foreach($residences['inactive'] as $residence)
        @include('fragments.residence', array('residence' => $residence, 'canUpdate' => $canUpdate))
    @endforeach
</div>