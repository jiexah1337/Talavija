<div class="row">
    <div class="col-md-6">
        <div class="info-line">
            <span>
                <b>Vārds, Uzvārds:</b>
            </span>
            <span>
                <strong>{{$user->name}}</strong> {{$user->surname}}
            </span>
        </div>

        <div class="info-line">
            <span>
                <b>Dzimšanas Datums:</b>
            </span>
            <span>
                @if($bio->birthdata->date() !== null)
                {{$bio->birthdata->date()}}
                @else
                -
                @endif
                <a data-toggle="collapse" href="#birthdata">
                    <i class="fas fa-caret-down"></i>
                </a>
            </span>
        </div>

        <div id="birthdata" class="collapse">
            <div class="info-line">
                <span>
                    <b>Dzimšanas Vieta:</b>
                </span>
                <span>
                    @if($bio->birthdata->location->country != '' && $bio->birthdata->location->city != '' && $bio->birthdata->location->address != '')
                    {{$bio->birthdata->location->country}}
                    {{$bio->birthdata->location->city}}
                    {{$bio->birthdata->location->address}}
                    @else
                        -
                    @endif

                    <?php if(!empty($bio->birthdata->location->notes) && $bio->birthdata->location->notes != " "): ?>
                        <i class="fas fa-question-circle text-primary" data-toggle="tooltip"
                        title="{{$bio->birthdata->location->notes}}"></i>
                    <?php endif;?>

                </span>
            </div>
        </div>


        <?php if(!isset($bio->deathdata->date)) : ?>

            <div class="info-line">
                <span>
                    <b>Dzīves vieta:</b>
                </span>
                <span>
                    @if(null !== $user->lastResidence())
                    {{$user->lastResidence()->location->country or ''}}
                    {{$user->lastResidence()->location->city or ''}}
                    {{$user->lastResidence()->location->address or ''}}

                        @if(!empty($user->lastResidence()->location->notes) && $user->lastResidence()->location->notes != " ")
                        <i class="fas fa-question-circle text-primary" data-toggle="tooltip"
                        title="{{$user->lastResidence()->location->notes}}"></i>
                        @endif
                    @else
                        -
                    @endif


                </span>
            </div>

        <?php endif; ?>




        <?php if(isset($bio->deathdata->date)) : ?>

        <div class="info-line">
            <span>
                <b>Miršanas Datums:</b>
            </span>
            <span>
                @if($bio->deathdata->date() !== null)
                {{$bio->deathdata->date()}}
                @else
                -
                @endif
                <a data-toggle="collapse" href="#deathdata">
                    <i class="fas fa-caret-down"></i>
                </a>
            </span>
        </div>

        <div id="deathdata" class="collapse">
            <div class="info-line">
                <span>
                    <b>Miršanas Vieta:</b>
                </span>
                <span>
                    {{$bio->deathdata->location->country or ''}}
                    {{$bio->deathdata->location->city or ''}}
                    {{$bio->deathdata->location->address or ''}}

                    @if(!empty($bio->deathdata->location->notes) && $bio->deathdata->location->notes != " ")
                        <i class="fas fa-question-circle text-primary" data-toggle="tooltip"
                        title="{{$bio->deathdata->location->notes}}"></i>
                    @endif

                </span>
            </div>
        </div>
        <?php endif; ?>

        <div class="info-line">
            <span>
                <b>Telefons</b>
            </span>
            <span>
                {{$user->phone or '-'}}
            </span>
        </div>

        <div class="info-line">
            <span>
                <b>E-Pasts</b>
            </span>
            <span>
                {{$user->email or '-'}}
            </span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="info-line">
            <span>
                <b>Oldermanis: </b>
            </span>
            <span>
            @if(isset($bio->olderman))
                <a href="/bio/{{$bio->olderman->member_id}}"><strong>{{$bio->olderman->name}}</strong> {{$bio->olderman->surname}} <i class="fa fa-link"></i></a>
            @else
                -
            @endif
            </span>
        </div>

        <div class="info-line">
            <span>
                <b>Krāsu tēvs: </b>
            </span>
            <span>
                @if(isset($bio->colfather))
                    <a href="/bio/{{$bio->colfather->member_id}}"><strong>{{$bio->colfather->name}}</strong> {{$bio->colfather->surname}} <i class="fa fa-link"></i></a>
                @else
                    -
                @endif
            </span>
        </div>

        <div class="info-line">
            <span>
                <b>Krāsu māte: </b>
            </span>
            <span>
                @if(isset($bio->colmother))
                    <a href="/bio/{{$bio->colmother->member_id}}"><strong>{{$bio->colmother->name}}</strong> {{$bio->colmother->surname}} <i class="fa fa-link"></i></a>
                @else
                    -
                @endif
            </span>
        </div>

        <div class="info-line">
            <span>
                <b>V!K!</b>
            </span>
            <span>
                @if($user->start_date())
                    {{$user->start_date()}}
                @else
                    -
                @endif
            </span>
        </div>

        <div class="info-line">
            <span>
                <b>Sp!K!</b>
            </span>
            <span>
                @if($user->spk_date())
                    {{$user->spk_date()}}
                @else
                    -
                @endif
            </span>
        </div>

        <div class="info-line">
            <span>
            <b>Filistrējies</b>
            </span>
            <span>
                @if($user->fil_date())
                    {{$user->fil_date()}}
                @else
                    -
                @endif
            </span>
        </div>
    </div>
</div>
