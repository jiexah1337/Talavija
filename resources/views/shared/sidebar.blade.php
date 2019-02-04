
<nav class="col-sm-3 col-md-2 bg-sidebar sidebar">
    <?php $user = Sentinel::getUser();?>
    @include('fragments.user-widget')
    <ul class="nav nav-pills flex-column nav-icon-center">

        <li class="nav-item bg-secondary text-success">
            <a href="/main" class="nav-link bg-secondary text-primary">
                Galvenā lapa
                <span class="pull-right">
                    <img src="{{asset('img/Talavija 2.png')}}" height="24px"/>
                </span>

            </a>
        </li>

        <li class="nav-item bg-secondary text-success">
            <a class="nav-link bg-secondary text-primary " data-toggle="collapse" href="#myOpts" role="button" aria-expanded="false" aria-controls="myOpts">
                Profils
                <span class="pull-right">
                    <i class="fas fa-user"></i>
                </span>
            </a>
        </li>
        <li class="nav-item bg-secondary text-success collapse" id="myOpts">
            <div class="collapse-group">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item bg-secondary text-success">
                        <a class="nav-link" href="/bio">
                            Mans Bio
                            <span class="pull-right">
                                <i class="fas fa-address-card"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link bg-secondary text-primary " data-toggle="collapse" href="#userOpts" role="button" aria-expanded="false" aria-controls="userOpts">
                Lietotāji
                <span class="pull-right">
                    <i class="fas fa-users"></i>
                </span>
            </a>
        </li>
        <li class="nav-item bg-secondary text-success collapse" id="userOpts">
            <div class="collapse-group">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item bg-secondary text-success">
                        <a class="nav-link" href="/users/list">
                            Lietotāju saraksts
                            <span class="pull-right">
                                <i class="fas fa-list-alt"></i>
                            </span>
                        </a>
                    </li>
                    <?php if($user->hasAccess(['user.create'])): ?>
                    <li class="nav-item bg-secondary text-success">
                        <a class="nav-link" href="/users/register">
                            Reģistrēt jaunu
                            <span class="pull-right">
                                <i class="fas fa-plus-square"></i>
                            </span>
                        </a>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
        </li>
        <?php if($user->hasAccess(['money.view'])): ?>

        <li class="nav-item bg-secondary text-success">
            <a class="nav-link bg-secondary text-primary " data-toggle="collapse" href="#money" role="button" aria-expanded="false" aria-controls="money">
                Reparticijas
                <span class="pull-right">
                    <i class="fas fa-euro-sign"></i>
                </span>
            </a>
        </li>
        <?php endif?>
        <li class="nav-item bg-secondary text-success collapse" id="money">
            <div class="collapse-group">
                <ul class="nav nav-pills flex-column">
                    <?php if($user->hasAccess(['money.view'])): ?>
                    <li class="nav-item bg-secondary text-success">
                        <a class="nav-link text-success" href="/money/">
                            Repartīcijas apskate
                            <span class="pull-right">
                    <i class="fas fa-euro-sign"></i>
                </span>
                        </a>
                    </li>
                    <?php endif ?>
                        <?php if($user->hasAccess(['money.view'])): ?>
                        <li class="nav-item bg-secondary text-success">
                            <a class="nav-link text-success" href="/money/add">
                                Ikmenesa maksajumi
                                <span class="pull-right">
                    <i class="fas fa-euro-sign"></i>
                </span>
                            </a>
                        </li>
                        <?php endif ?>
                        <?php if($user->hasAccess(['money.view'])): ?>
                        <li class="nav-item bg-secondary text-success">
                            <a class="nav-link text-success" href="/money/upload">
                                Maksājumu imports
                                <span class="pull-right">
                    <i class="fas fa-euro-sign"></i>
                </span>
                            </a>
                        </li>
                        <?php endif ?>

                </ul>
            </div>
        </li>


        <?php if($user->hasAccess(['admin.panel-access'])): ?>
        <li class="nav-item bg-secondary text-success">
            <a class="nav-link text-success" href="/admin/main">
                Sistēma
                <span class="pull-right">
                    <i class="fas fa-cogs"></i>
                </span></a>
        </li>
        <?php endif ?>
        <?php if($user->hasAccess(['calendar.event-access'])): ?>
        <li class="nav-item bg-secondary text-success">
            <a class="nav-link text-success" href="/cal/create">
                Kalendars
                <span class="pull-right">
                    <i class="fas fa-calendar"></i>
                </span></a>
        </li>
        <?php endif ?>
        <li class="nav-item bg-secondary text-success">
            <a href="/logout" class="nav-link bg-secondary text-primary">
                Iziet
                <span class="pull-right">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
            </a>
        </li>
    </ul>
</nav>