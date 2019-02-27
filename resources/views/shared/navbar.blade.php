
<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-dark bg-dark">
    <?php $user = Sentinel::getUser();?>
    <a class="navbar-brand" href="/main">
        <span class="pull-right">
            <img src="{{asset('img/Talavija 2.png')}}" height="24px"/>
        </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="nav w-100 order-1 order-md-0">
            <ul class="navbar-nav w-100 mr-auto nav-icon-center">

                <li class="nav-item">
                    <a class="nav-link bg-dark text-primary" href="/bio">
                        Mans Bio
                        <span class="pull-right">
                            <i class="fas fa-address-card"></i>
                        </span>
                    </a>
                </li>


                <li class="nav-item dropdown bg-dark text-success">
                    <a class="nav-link dropdown-toggle text-success" href="#" id="userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Lietotāji
                        <span class="pull-right">
                            <i class="fas fa-users"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu bg-dark " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-success" href="/users/list">Lietotāju saraksts</a>
                        <?php if($user->hasAccess(['user.create'])): ?>
                        <a class="dropdown-item text-success" href="/users/register">Reģistrēt jaunu</a>
                        <?php endif ?>
                    </div>
                </li>

                <?php if($user->hasAccess(['money.view'])): ?>
                <li class="nav-item dropdown bg-dark text-success">
                    <a class="nav-link dropdown-toggle text-success" href="#" id="money" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Repartīcijas
                        <span class="pull-right">
                            <i class="fas fa-euro-sign"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu bg-dark " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-success" href="/money/">Repartīcijas apskate</a>
                        <a class="dropdown-item text-success" href="/money/add"> Ikmenesa maksajumi</a>
                    </div>
                </li>
                <?php endif ?>
                <?php if($user->hasAccess(['calendar.event-access'])): ?>
                <li class="nav-item bg-dark text-success">
                    <a class="nav-link text-success" href="/cal/create">
                        Kalendars
                        <span class="pull-right">
                    <i class="fas fa-calendar"></i>
                </span></a>
                </li>
                <?php endif ?>
                <?php if($user->hasAccess(['admin.panel-access'])): ?>
                <li class="nav-item">
                    <a class="nav-link bg-dark text-primary" href="/admin/main">
                        Sistēma
                        <span class="pull-right">
                        <i class="fas fa-cogs"></i>
                    </span>
                    </a>
                </li>
                <?php endif ?>
                <li class="nav-item">
                    <a class="nav-link bg-dark text-primary" href="/logout">
                        Iziet
                        <span class="pull-right">
                        <i class="fas fa-sign-out-alt"></i>
                    </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>