@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">

        <h1>Galvenā lapa</h1>

        <div>
            <ul class="nav nav-tabs" id="news-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="news-tab" data-toggle="tab" href="#news" role="tab"
                       aria-controls="news" aria-selected="true">Ziņas/Jaunumi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="todo-tab" data-toggle="tab" href="#todo" role="tab" aria-controls="todo"
                       aria-selected="false">Darāmo darbu saraksts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="system-tab" data-toggle="tab" href="#system" role="tab"
                       aria-controls="system" aria-selected="false">Sistēmas izmaiņas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link" id="calendar-tab" data-toggle="tab" href="#calendar" role="tab"
                       aria-controls="calendar" aria-selected="false">Kalendars</a>
                </li>
            </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="news" role="tabpanel" aria-labelledby="news-tab">
                <div class="row">
                    <div class="col-11">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link page-btn" data-increment="-5" href="#"><i
                                                class="fas fa-angle-double-left"></i></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link page-btn" data-increment="-1" href="#"><i
                                                class="fas fa-angle-left"></i></a>
                                </li>
                                <li class="page-item">
                                    <input type="number" min="1" max="{{$pageCount}}" id="pageField"
                                           data-pagecount="{{$pageCount}}" class="page-link text-center" width="50px"
                                           value="{{$page or 1}}">
                                </li>
                                <li class="page-item">
                                    <a class="page-link page-btn" data-increment="1" href="#"><i
                                                class="fas fa-angle-right"></i></a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link page-btn" data-increment="5" href="#"><i
                                                class="fas fa-angle-double-right"></i></a>
                                </li>
                                @if(Sentinel::getUser()->hasAccess('news.post'))
                                    <li class="nav-item">
                                        <a href="#" class="page-link" data-toggle="tooltip" title="Jauns ziņojums"
                                           id="newPostBtn"><i class="fas fa-plus-square"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="col-1">

                        <script>
                            $('#newPostBtn').on('click', function (e) {
                                e.preventDefault();
                                $.ajax({
                                    type: 'GET',
                                    url: '/news/add',
                                    success: function (data) {
                                        $('#modalContainer').html(data.html);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                {{--LOADER SPINNER--}}
                <div class="loader" id="loader">
                    <div class="card">
                        <div class="card-body text-center text-info">
                            <i class="fas fa-spinner fa-spin h4"></i>
                        </div>
                    </div>
                </div>
                {{--END LOADER SPINNER--}}
                <div id="news-box">

                </div>
            </div>



            <div class="tab-pane " id="calendar" role="tabpanel" aria-labelledby="calendar-tab">

                <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=jiexah1338%40gmail.com&amp;color=%231B887A&amp;ctz=Europe%2FRiga" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>

              
            </div>



            <div class="tab-pane" id="todo" role="tabpanel" aria-labelledby="todo-tab">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" id="donePb"></div>
                    <div class="progress-bar bg-warning" id="wipPb" role="progressbar"></div>
                    <div class="progress-bar bg-danger" id="ndPb" role="progressbar"></div>
                </div>

                <script>
                    $(document).ready(function () {
                        var done = $("#done-list>li").length;
                        var wip = $("#wip-list>li").length;
                        var notdone = $("#not-done-list>li").length;

                        var total = (done + wip + notdone);
                        $("#donePb").width(done / total * 100 + '%');
                        $("#wipPb").width(wip / total * 100 + '%');
                        $("#ndPb").width(notdone / total * 100 + '%');

                        $("#donePb").html(done);
                        $("#wipPb").html(wip);
                        $("#ndPb").html(notdone);


                    })
                </script>

                <div class="row">
                    <div class="col-md-4">
                        <div class="text-primary">
                            <h5>Veikts</h5>
                            <ul id="done-list">
                                <li>Lietotāju reģistrācija</li>
                                <li>Lietotāju autorizācija</li>
                                <li>Lietotāju saraksts</li>
                                <li>Lietotāju meklēšana</li>
                                <li>Dzīves vietu pievienošana / apskate</li>
                                <li>Darba vietu pievienošana / apskate</li>
                                <li>Studiju vietu pievienošana / apskate</li>
                                <li>Formu aizvietošana ar AJAX formām</li>
                                <li>Lietotāju personīgās informācijas dzēšana</li>
                                <li>Lietotāju ģimenes informācijas lauki</li>
                                <li><b>Lietotāju reģistrācija -> Oldermaņa, krāsu mātes/tēva meklēšana un
                                        izveidošana</b></li>
                                <li><b>Lietotāju personīgās informācijas rediģēšana</b></li>
                                <li>WYSIWYG Redaktora implementēšana</li>
                                <li>Lietotāju saraksta optimizācijas</li>
                                <li>Repartīciju apskate</li>
                                <li>Lietotāju bildes</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-warning">
                            <h5>Izstrāde</h5>
                            <ul id="wip-list">
                                <li>Dizaina renovācijas</li>
                                <li><b>Lietotāju BIO .PDF ģenerēšana</b></li>
                                <li>Google Maps integrācija ar adresēm</li>
                                <li><b>Lietotāju aktivizācija</b></li>
                                <li>Lietotāju statusi</li>
                                <li>Repartīciju tabula</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-danger">
                            <h5>Nav izstrādāts</h5>
                            <ul id="not-done-list">
                                <li>Protokoli, Iesniegumi</li>
                                <li>Pasākumi [Google Calendar Integrācija]</li>
                                <li>Atgādinājumi, E-Pasts [Google Calendar Integrācija]</li>
                                <li>Sodi</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="system" role="tabpanel" aria-labelledby="system-tab">
                <h1>Izmaiņas / Ziņas</h1>
                <div class="row">
                    <div>
                        <div class="card-body">
                            <h4>14.06.18</h4>
                            <ul>
                                <li>Ziņu rakstīšanas logā vairs neuzrādas dīvaina rīkjosla.</li>
                                <li>Ziņojumu rakstīšanas laikā, ātri spaidot pogu "Saglabāt", vairs netiks saglabātas tik daudz ziņas, cik nospiesta poga.</li>
                                <li>Teksta redaktoros vairs nevar ievietot bildes.</li>
                                <li>Mainot biedra statusu vairs nevajag pārlādēt lapu lai redzētu izmaiņas.</li>
                                <li>Statusu opcijas ir pieejamas sistēmas panelī.</li>
                                <li>Reģistrācijā ievietota validācija vārdam un uzvārdam.</li>
                                <li>Biogrāfijas skatā pareizi uzrādīta pēdējā dzīves vieta.</li>
                                <li>Datu ievades formās pievienoti <span class="required"></span> lai norādītu uz obligātiem laukiem.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>01.06.18</h4>
                            <ul>
                                <li>Vairāk validācijas pie parolēm: min - 6 simboli. Jāizpildās 3 no šiem kritērijiem:
                                    <ul>
                                        <li>Satur burtus A-Z.</li>
                                        <li>Satur burtus a-z.</li>
                                        <li>Satur ciparus 0-9.</li>
                                        <li>Satur simbolus !, #, @, % u.c.</li>
                                    </ul>
                                </li>
                                <li>Ziņojumos fona zīmogi vairs nav gigantiski kad ziņojumi ir gari.</li>
                                <li>Izlabota kļūme kas neļāva saglabāt/rediģēt/dzēst darba vietas, dzīves vietas un studijas.</li>
                                <li>Vairāk nelietojam Sesijā glabātus mainīgos.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>31.05.18</h4>
                            <ul>
                                <li>
                                    Progress ar lietotāju aktivizēšanu!
                                    <ul>
                                        <li>Nav vēl funkcionāls izstrādē. Vajadzīgs pasta serveris.</li>
                                        <li>Strādā lokālajā vidē.</li>
                                        <li>Pēc lietotāja reģistrācijas uz e-pastu sūta ziņu par aktivizēšanu. Nospiežot
                                            uz saites tiek novirzīts uz lapu kur uzstāda savu paroli.
                                        </li>
                                        <li>Lietotājs tiek aktivizēts un novirzīts uz galveno lapu.</li>
                                    </ul>
                                    Vajadzīgs serveris ko uzstādīt, lai varētu sūtīt pastu. Lokāli izmantoju <a
                                            href="mailtrap.io">mailtrap</a> kas atļauj sūtīt neīstus e-pastus.
                                    <br>
                                    Funkcionāli viss strādā, jāuzlabo dizains.
                                </li>
                                <li>Refaktorēšana un atļauju uzlabojumi.</li>
                                <li>Datubāžu seeder: Ģenerē Administratora kontu un noklusējuma amatus, statusus.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>24.05.18</h4>
                            <ul>
                                <li>Refaktorēšana - izmainītas dažas lietas kas bija palikušas no sistēmas sākuma ar
                                    jaunākām/labākām lietām. Funkcionalitāte nav mainījusies.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>22.05.18</h4>
                            <ul>
                                <li>Ziņojuma dēļa lapu navigācija vairs neuzrādas pie darāmo darbu saraksta un sistēmas
                                    izmaiņām.
                                </li>
                                <li>Profila bildēm pieejams bildes apgraizīšanas rīks. Bilžu augstuma/garuma proporcija
                                    vienmēr ir 1:1 un pēc apstrādes bildes izmērs ir 500x500.
                                </li>
                                <li>Ja lietotājam nav ievadīta dzimšanas vieta uzrādīsies '-'.</li>
                                <li>Studiju noklusējuma dati: Sākuma datums 01/09/----, beigu: 30/06/----</li>
                                <li>.PDF - uzrādīti V!K!, Sp!K! un filistrēšanās datumi, kā arī profila bilde.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>21.05.18</h4>
                            <ul>
                                <li>Jauna atļauja "Ziņojumu rakstīšana" - atļauj rakstīt ziņas.</li>
                                <li>Sadalīta galvenā lapa 3 apakšskatos: Jaunumi, Darāmie darbi un Izmaiņas.</li>
                                <li>Pēc reģistrācijas lietotājs tiek redirectots uz reģistrēto lietotāju.</li>
                                <li>Pie reģistrācijas "Korporācijas vēsture" vairs nav obligāta.</li>
                                <li>Pie reģistrācijas Old! vairs nav obligāts.</li>
                                <li>Salabota absolvēšana studiju reģistrācijā.</li>
                                <li>Ziņu sadaļa! Lai rakstītu ziņas vajadzīga atļauja. (uzstādiet to sistēmas pārvaldē
                                    tiem amatiem kas to var izmantot!).
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>18.05.18</h4>
                            <ul>
                                <li>Jauna atļauja "Lietotāju Oldermaņa, K!Tēva un K!Mātes rediģēšana" - atļauj mainīt
                                    lietotāju Old!, K!Tēvu un K!Māti.
                                </li>
                                <li>Jauna atļauja "Lietotāju dzimšanas un nāves datu rediģēšana" - atļauj rediģēt
                                    lietotāju dzimšanas un nāves datus.
                                </li>
                                <li>Biogrāfijas skatā Pamatinformācija un Old!, K!Tēvs, K!Māte apvienoti vienā "blokā"
                                    un rediģēšanas logi ir apvienoti vienā, kā arī padarīti plašāki.
                                </li>
                                <li>Lielāka konsistence vietās bez ievadītiem datiem (vietās bez datiem uzrādīts '-').
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>17.05.18</h4>
                            <ul>
                                <li>Sānu izvēlne ir atpakaļ. Mazos ekrānos tiek izmantota augšējā izvēlne.</li>
                                <li>Jauna privilēģija - "user.history" - Atļauj mainīt datus par lietotāja vēsturi
                                    korporācijā.
                                </li>
                                <li>Jauna privilēģija - "news.post" - Atļaus ievietot ziņas galvenajā lapā.</li>
                                <li class="text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Lai izmantotu šīs jaunās privilēģijas, sistēmas pārvaldē tās piesniedziet
                                    attiecīgajiem amatiem.
                                    <i class="fas fa-exclamation-triangle"></i>
                                </li>
                                <li>Pie korporācijas vēstures ievietoti divi jauni lauki: "Uzņemts Sp!K!" un
                                    "Filistrējies".
                                </li>
                                <li>Pie korporācijas vēstures "Biedrs kopš" pārsaukts par "Uzņemts V!K!".</li>
                                <li>Paroles mainītājs ir mazāk agresīvs un atļaus to nedarīt.</li>
                                <li>Repartīcijām iedoti lauki priekš reparticijas ierakstīšanas datuma un repartīcijas
                                    samaksas datuma.
                                </li>
                                <li>Reģistrācijas laikā pareizi tiks noteikts vai biedrs ir miris.</li>
                                <li>Ievietoti vairāki placeholder teksti kas nebija ievietoti.</li>
                                <li>Salabots placeholder priekš oldermaņa, K!tēva un K!mātes laukiem biogrāfijas
                                    rediģēsanas skatā.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>16.05.18</h4>
                            <ul>
                                <li>Pāreja no sānu izvēlnes uz augšējo izvēlni. Šis atļauj lielāku konsistenci starp
                                    mobīlo un pilno versiju, kā arī atļauj parādīt vairāk informāciju uz ekrāna.
                                </li>
                                <li>Bootstrap atjaunināts uz versiju 4.1</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>15.05.18</h4>
                            <ul>
                                <li>Statusi tiek uzrādīti arī repartīciju tabulā.</li>
                                <li>Statusu var izvēlēties reģistrācijas laikā.</li>
                                <li>Reģistrējot var ievadīt datumu no kura biedrs ir daļa no korporācijas.</li>
                                <li>Mēnešu ievadīšana pārmainīta uz izvēlni.</li>
                                <li>Biogrāfija, Biedrziņa piezīmes uzrādās .PDF failā.</li>
                                <li>Ievietoti placeholder teksti formu logos.</li>
                                <li>Vairāk konsistences starp mirušo un dzīvo biedru biogrāfijas lapām.</li>
                                <li>Ja E-Pasts nav ievadīts formā, uzrādas paraugs, kā tas izskatīsies pēc
                                    reģistrācijas.
                                </li>
                                <li>Jaunais ģenerēto e-pastu formāts ir vārds.uzvārds.biedranr@talavija-nomail.lv</li>
                                <li>Nepareizi ievadīts datums atgriezīs ziņojumu par kļūmi.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>11.05.18</h4>
                            <ul>
                                <li>Izlabots datumu formāts uz dd/mm/yyyy un datuma ievadei viena lauka vietā izmanto 3
                                    laukus (Dienai, mēnesim un gadam atsevīšķi) iekš:
                                    <ul>
                                        <li>Reģistrācijas</li>
                                        <li>Dzimšanas dati</li>
                                        <li>Nāves dati</li>
                                        <li>Darba vietas</li>
                                        <li>Studijas</li>
                                        <li>Dzīves vietas</li>
                                        <li>.PDF failā</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>10.05.18</h4>
                            <ul>
                                <li>Reģistrācijā atļauts neievadīt epastu. Tas tiks saglabāts kā
                                    vārds.uzvārds@talavija-nomail.lv, ja nav ievadīts
                                </li>
                                <li>Reģistrācijā atļauts neievadīt telefona numuru.</li>
                                <li>Pēc reģistrācijas, ievadītais Oldermanis, K! Tēvs, K!Māte uzrādīsies pareizi
                                    biogrāfijā.
                                </li>
                                <li>Biogrāfijas lapā pēc Oldermaņa/K!Tēva vai K!mātes rediģēšanas dati tiks saglabāti
                                    pareizi.
                                </li>
                                <li>Studēšanas pievienošanai vairs nav nepieciešams ievadīt Grādu, Fakultāti un
                                    Programmu.
                                </li>
                                <li>Administratori tagad var mainīt biedrziņa piezīmes (Atļaujas var mainīt sistēmas
                                    pārvaldes sekcijā ;) ).
                                </li>
                                <li>Rediģējot studijas, absolvēšanas status uzrādīsies pareizi.</li>
                                <li>Biedru sarakstā uzrādīts arī katra biedra statuss!<br><span class="text-danger"><i
                                                class="fas fa-exclamation-triangle"></i> VISIEM LIETOTĀJIEM KURIEM NAV STATUSA UN KURI REDZAMI UZ EKRĀNA TIKS PIEŠĶIRTS NOKLUSĒJUMA STATUSS <i
                                                class="fas fa-exclamation-triangle"></i></span></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>07.05.18</h4>
                            <ul>
                                <li>Lietotāja pamatinformācijas rediģēšana.</li>
                                <li>Iespēja mainīt savu paroli! Lai mainītu paroli jāievada tagadējā parole un divreiz
                                    jaunā parole. Ja jaunās paroles nesakrīt, informāciju neļauj saglabāt.
                                </li>
                                <li>Amatus var atzīmēt kā dzēšamus un tie tiks dzēsti pēc saglabāšanas.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>02.05.18</h4>
                            <ul>
                                <li>Izlabota kļūme kas ieviesta pēc pēdējā atjauninājuma - Dzēšanas logi neuzrādās pie
                                    dzēšanas pogas nospiešanas Darba vietu, Studiju un Dzīves vietu paneļos.
                                </li>
                                <li>Ieņemtie amati un tagadējais amats uzrādīts .PDF</li>
                                <li>Pievienots lauks repartīcijām lai saglabātu saņemto summu.</li>
                                <li>Repartīciju tabula uzskaita saņemto repartīciju summu.</li>
                                <li>Izlabota kļūme kas neļāva piekļūt izveido biedru kontiem ar paroli "placeholder".
                                    Visi nākamie testa biedri izmantos šo paroli testa nolūkiem. Īstai paroļu sistēmai
                                    vajadzēs Mail serveri, aktivācijas e-pastus un iespēju mainīt savu paroli.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>27.04.18</h4>
                            <ul>
                                <li>Repartīciju mēneša skats pārvietots uz atsevišķu lapu, lai salabotu pāris kļūmes ar
                                    Modal pārklājumiem un vispārēju informācijas uztveramību.
                                </li>
                                <li>Repartīciju mēneša skatā pēc ierakstu rediģēšanas vai dzēšanas lapa vairs nav
                                    jāpārlādē - implementēti ajax saucieni lai to darītu asinhroni.
                                </li>
                                <li>Repartīciju tipi datubāzē tagad tiek saglabāti latviešu valodā. [Un arī beidzot tiek
                                    saglabāti datubāzē pēc mazas kļūmes izlabošanas].
                                </li>
                                <li><i class="fab fa-js"></i> Pievienoti parametri <code>editButtonOverride()</code>
                                    metodei lai atļautu mainīt uz kurām pogām tā attiecas un modal loga mērķa objektu. [<code>editButtonOverride(pogasKlase,
                                        modalMērķis)</code>]
                                </li>
                                <li><i class="fab fa-js"></i> Pievienots parametrs <code>deleteButtonOverride()</code>
                                    metodei lai atļautu izlaist modal loga rādīšanu. [<code>deleteButtonOverride(useModal)</code>]
                                </li>
                                <li><i class="fab fa-font-awesome"></i> Atjaunināts Font Awesome uz versiju 5.0.10.</li>
                                <li>Implementēta individuālu repartīciju pievienošana. Pēc pievienošanas, individuālā
                                    mēneša lapa automātiski tiek atjaunināta bez pārlādes asinhronu saucienu dēļ.
                                </li>
                                <li>Repartīciju tabula tagad saskaita visus sodus un uzrāda to summu.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>26.04.18</h4>
                            <ul>
                                <li>Mēneša repartīciju apskatē ievietotas pogas rediģēšanai un dzēšanai. Nākamajā lapas
                                    verisjā: Pievienošana...
                                </li>
                                <li>Implementēta repartīciju rediģēšana un dzēšana. [! Pagaidām pēc dzēšanas dati uzreiz
                                    netiek atjaunoti un var redzēt izmaiņas tikai pēc lapas pārlādes. Tas tiks mainīts
                                    nākamajā versijā !]
                                </li>
                                <li>Rediģēšanas laikā var izvēlēties repartīcijas tipu: Maksājums / Sods / Prēmija /
                                    Cits.
                                </li>
                                <li>Izlaboti konflikti starp dažiem Route, kas izraisīja kļūmes pie noteiktiem datiem.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>25.04.18</h4>
                            <ul>
                                <li>Metodes kas saistītas ar statusiem pārvietotas no Administrācijas kontroliera uz
                                    Statusu kontrolieri.
                                </li>
                                <li>Statusu sarakstā administrācijas panelī izlabota kļūme kas nerādīja statusa
                                    nosaukumu.
                                </li>
                                <li>Statusu apskatīšanas laikā, ja lietotājam nav statusa, tiek piešķirts noklusējuma
                                    status tā gada tekošajā semestrī.
                                </li>
                                <li>Administrācijas panelī iespējams uzstādīt nmoklusējuma statusu.</li>
                                <li>Administrācijas panelī pēc dzēšanas/izveidošanas, saraksts tiek pārlādēts
                                    rediģēšanas lauks.
                                </li>
                                <li>Noklusējuma statusu nav atļauts dzēst.</li>
                                <li>Administrācijas panelī izlecošajiem logiem salabota aizvēršanas poga.</li>
                                <li>Biogrāfijas lapā pie biedra vārda un uzvārda uzrādīts statusa saīsinājums.</li>
                                <li>Statusus var piešķirt Biogrāfijas lapā nospiežot us statusa. Var izvēlēties jauno
                                    statusu kas tiks piešķirts uz tekošā gada tekošo semestri.
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h4>24.04.18</h4>
                            <ul>
                                <li>Sistēmas drošības papildinājumi ar ziņām par atļauju trūkumu.</li>
                                <li>Refaktorēšana...</li>
                            </ul>

                        </div>
                        <div class="card-body">
                            <h4>21.04.18</h4>
                            <ul>
                                <li>Datubāzē pievienota tabula lietotāju un statusu relācijām. Reģistrēts tiek Status,
                                    Lietotājs, Gads un semestris. [vajadzīgs Python scripts lai skatītu statusa beigu
                                    termiņu un attiecīgu statusa maiņu].
                                </li>
                                <li>Pievienots jauns panelis administrācijas lapā statusu veidošanai. [Nākamajā versijā
                                    lietotājiem varēs piešķirt statusus].
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>19.04.18</h4>
                            <ul>
                                <li>.PDF ģenerēšanā iekļauti dati par darba vietām.</li>
                                <li>Salaboti "Tukšie komati" (, , ,) pie datiem .PDF pie adresēm, ja ir trūkstoši
                                    dati.
                                </li>
                                <li>Kļūmes par telefona numura nepieciešamību dotas bez lapas pārlādes.</li>
                                <li>Ievietoti jaunie amati:
                                    <ul>
                                        <li>Seniors</li>
                                        <li>Vice seniors</li>
                                        <li>Sekretārs</li>
                                        <li>Oldermanis</li>
                                        <li>Magister Litterarum</li>
                                        <li>Magister Cantandi</li>
                                        <li>Magister Paucandi</li>
                                        <li>Kasieris</li>
                                        <li>Ekonoms</li>
                                        <li>Bibliotekārs</li>
                                        <li>Major Domus</li>
                                        <li>Arhivārs</li>
                                        <li>Internās tiesas priekšsēdētājs</li>
                                        <li>Internās tiesas tiesneši/li>
                                        <li>Eksternie goda tiesas tiesneši</li>
                                        <li>Revīzijas komisijas priekšsēdētājs</li>
                                        <li>Revīzijas komisijas locekļi</li>
                                        <li>Atbildīgais par datoru</li>
                                    </ul>
                                    <hr>
                                    Lielai daļai no šiem amatiem vēl nav nozīmes/privilēģijas
                                </li>
                                <li>Pievienots favicon</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>18.04.18</h4>
                            Reģistrācijas formas maiņas :
                            <ul>
                                <li>Noņemtas atsevišķās nodaļas, lai vieglāk redzētu ievadīto informāciju un palīdzētu
                                    ar validāciju.
                                </li>
                                <li>Telefona numuru un e-pasta validācijas laikā tiek parādītas ziņas, ja pieļauta
                                    kļūme.
                                </li>
                                <li>Paziņojums par oldermaņa/krāsu tēva/krāsu mātes biedru numuru vienādību ar
                                    reģistrējamā lietotāja biedra numuru.
                                </li>
                            </ul>
                            <hr>
                            Biogrāfijas lapas maiņas :
                            <ul>
                                <li>Ja pēcteču nav, netiek uzrādīts tukšs saraksts.</li>
                                <li>Ja citu saistītu cilvēku nav, netiek uzrādīts tukšs saraksts.</li>
                                <li>Dzīvesvietas uzrāda intervālu nevis sākuma un beigu datumus.</li>
                                <li>Ja darba/studiju/dzīves vietu sarakstā nav neviena ieraksta, neuzrāda "parādīt
                                    vairāk" pogu.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>16.04.18</h4>
                            <ul>
                                <li>Nomainīti daži CDN no Http uz Https linkiem (summernote ir atpakaļ).</li>
                                <li>Reģistrācijas laikā sistēma vairs nekļūmēsies, ja oldermanis / krāsu māte / krāsu
                                    tēvs nav noteikts.
                                </li>
                                <li>Salabota Darba vietu, Studiju un Dzīves vietu dzēšana. Nekādas nojausmas kā tas
                                    salūza...
                                </li>
                                <li>Navigācijas izvēlnē nomainītas krāsas Repartīciju un Administrācijas saitēm, lai
                                    būtu saskaņotas ar pārējām.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>13.04.18</h4>
                            <ul>
                                <li>Asinhrona lapu skatīšana repartīciju tabulā.</li>
                                <li>Asinhrona lapu skatīšana lietotāju sarakstā.</li>
                                <li>Izlabota kļūme kas neļāva apskatīt repartīcijas informāciju pēc lapas vai gada
                                    maiņas.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>12.04.18</h4>
                            <ul>
                                <li>Salabota kļūme ar reģistrāciju bez miršanas datuma. Atkal.</li>
                                <li>Meklēšana repartīciju tabulā ir impplimentēta.</li>
                                <li>Notīrot meklēšanas lauku lietotāju/repartīciju sarakstā, rezultāti ir notīrīti un
                                    parādīti iepriekšējie dati.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>10.04.18</h4>
                            Optimizācijas lietotāju sarakstam:
                            <ul>
                                <li>Ielādēti 25 ieraksti lapā un pievienota lapu izvēlne.</li>
                                <li>Meklēšana darbojas ar datubāzi nevis ielādētajiem lietotājiem.</li>
                            </ul>
                            Optimizācijas repartīciju tabulai:
                            <ul>
                                <li>Ielādēti 25 ieraksti lapā un pievienota lapu un gada izvēlne.</li>
                                <li>Meklēšana darbojas ar datubāzi nevis ielādētajiem lietotājiem.</li>
                            </ul>

                            Nākamajā versijā:
                            <ul>
                                <li>Repartīciju rediģēšana/pievienošana.</li>
                                <li>Repartīciju tipi (sodi u.c.).</li>
                                <li>Repartīciju meklēšana.</li>
                                <li>Lietotāju saraksta un Repartīciju tabulas ātrāka darbība (Asinhroni saucieni uz
                                    back-end)
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>09.04.18</h4>
                            Darbs pie repartīciju tabulas:
                            <ul>
                                <li>Uzrāda īstus lietotājus.</li>
                                <li>Formatēšana negatīviem/pozitīviem skaitļiem.</li>
                                <li>Repartīciju summēšana.</li>
                                <li>Repartīciju gada summas.</li>
                                <li>Biedru numuri ir saites uz biedra biogrāfijas lapu.</li>
                                <li>Vienkāršs logs repartīciju informācijas apskatei (Pievienošana vēl nav
                                    funkcionāla).
                                </li>
                            </ul>
                            Nākamajā versijā:
                            <ul>
                                <li>Repartīciju rediģēšana/pievienošana.</li>
                                <li>Tabulas gada mainīšana.</li>
                                <li>Repartīciju tipi (sodi u.c.).</li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h4>04.04.18</h4>
                            <ul>
                                <li>Pierakstīšanās lapā nomainīts fona attēls uz bildi bez autortiesību nosacījumiem un
                                    noņemti krāsu efekti lai paātrinātu darbību uz lēnākām sistēmām.
                                </li>
                                <li>Amatu veidošana tagad ir iespējama.</li>
                                <li>Amatu piešķiršana ir funkcionāla.</li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h4>27.03.18</h4>
                            <ul>
                                <li>Izlabota kļūme Ģimenes redaktorā, kas pievienoja nevajadzīgu "}" saraksta beigās.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>22.03.18</h4>
                            <ul>
                                <li>Profila bilžu aukšupielādēšanas sākums! Bildes tiek palielinātas/samazinātas līdz
                                    500x500px un 100x100px sīkattēliem.
                                </li>
                                <li>Plānots interfeiss bilžu izgriežšanai, lai kontrolētu kura bildes daļa tiek
                                    augšupielādēta.
                                </li>
                                <li>Pagaidām sistēma izgriež bildes centru, cenšoties saglabāt augstuma un platuma
                                    proporcijas.
                                </li>
                                <li>Biogrāfijā pēctečus un citus ģimenes locekļus attēlo kā sarakstu. Tos ievada ar
                                    atstarpem starp cilvēkiem.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>21.03.18</h4>
                            <ul>
                                <li>Bijušo dzīvesvietu, darbavietu un studiju dizains atšķirās no tekošajiem.<br>
                                    Tie ir arī paslēpti pēc noklusējuma. Lai apskatītu tos, nospiediet <i
                                            class="fas fa-angle-double-down text-primary"></i>, un lai paslēptu - <i
                                            class="fas fa-angle-double-up text-primary"></i></li>
                                <li>Vairāk ikonas pie sānu izvēlnes</li>
                                <li>Noņemta lapas galvene, jo tai nebija pietiekami daudz lietošanas nozīmes lai to
                                    atstātu. <br>
                                    Lai tiktu uz galveno lapu un izietu no portāla, pogas pārvietotas uz sānu izvēlni.
                                </li>
                                <li><i class="fas fa-birthday-cake"></i>
                                    WYSIWYG redaktora implementācija! Beidzot! To var izmantot Biogrāfijā un Biedrziņa
                                    piezīmēs!
                                </li>
                                <li class="text-danger">Pagaidām nav ieteicams izmantot failu augšupielādi iekš WYSIWYG
                                    redaktora, jo var rasties problēmas ar pārāk lieliem failiem.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>20.03.18</h4>
                            <ul>
                                <li>Mirušu cilvēku biogrāfijai ir pelēks un tumšāks izskats (Tiks papildināts).</li>
                                <li>Izlabota kļūda ar lietotāja Darba vietu, Studiju un Dzīves vietu ielādēšanu pēc
                                    pievienošanas.
                                </li>
                                <li>"Statusi un atļaujas" pārsaukts par "Amati un atļaujas"</li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>19.03.18</h4>
                            <ul>
                                <li>Izlabotas kļūmes kodā.</li>
                                <li>Sākts darbs pie mirušu un dzīvu cilvēku bio atšķirīgajiem dizainiem.</li>
                                <li>Nelielas izmaiņas kodā (Mana saprāta labā).</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>16.03.18</h4>
                            <ul>
                                <li>Lietotāju biogrāfijās mainīta parādītā informācija. Dzimšanas vietu uzrāda tikai pēc
                                    dzimšanas datumam blakus esošās pogas ( <i
                                            class="fas fa-caret-down text-success"></i> ) nospiešanas.
                                </li>
                                <li>Ģimenes locekļus uzrāda bio lapas apakšā pie biogrāfijas.</li>
                                <li>Biogrāfijas sadaļā ir divas rediģēšanas pogas - pirmā priekš ģimenes, otrā - priekš
                                    biogrāfijas.
                                </li>
                                <li>Refaktorēšana...</li>
                                <li>Darbavietu, Studiju un Dzīvesvietu kolonnas ir limitētas augstumā.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>15.03.18</h4>
                            <ul>
                                <li>Sākts darbs pie repartīciju tabulas.</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>13.03.18</h4>
                            <ul>
                                <li>Pievienots Administrācijas panelis.</li>
                                <li>Adminsitrācijas panelī iespējams nomainīt Statusu atļaujas. Statusu piešķiršana un
                                    veidošana vēl nav iespējama
                                </li>
                                <li>Lietotāji bez Lietotāju rediģēšanas atļauju var rediģēt tikai savu Bio.</li>
                                <li>Noklusējuma status ir z!.</li>
                                <li>Ja pēc sistēmas atjaunināšanas ir lietotāji kas nespēj veikt darbības pat pēc
                                    statusa "z!" atļauju mainīšanas, caur serveri jāpalaiž komanda <br> <code> php
                                        artisan db:seed --class MissingAssignmentSeeder</code> <br> Tas var aizņemt kādu
                                    laiku pie lielas datubāzes
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>07.03.18</h4>
                            <ul>
                                <li>Lietotājiem iespējams pievienot miršanas datus.</li>
                                <li>K!Tēva, K!Mātes un Old! Rediģēšana</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>06.03.18</h4>
                            <ul>
                                <li>Lietotāju pamata informācija (Dzimšanas datums, Vieta, Tēvs, Māte, Pēcteči) tagad ir
                                    rediģējama!
                                </li>
                                <li>Dzimšanas un miršanas datu datumi vairs neuzrādīsies kā 1970.01.01, kur tas vēl
                                    nebija salabots. Izmaiņas skars tikai jaunus ierakstus
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>05.03.18</h4>
                            <ul>
                                <li>Iespējams pievienot gan lietotāja pašu biogrāfiju, gan biedrziņa piezīmes.</li>
                                <li>Vārda un Uzvārda lauki prieks Old!, K!Tēva un K!Mātes ir atpakaļ. Pievienots arī
                                    lauks priekš biedra numura.
                                </li>
                                <li>Reģistrācijas laikā ja ievadīts aizņemts biedra numurs, uzrādās ziņa par to, kopā ar
                                    saiti uz šī biedra biogrāfijas lapu.
                                </li>
                                <li>Krāsu tēvs un krāsu māte vairs nav obligāti lauki.</li>
                                <li>Papildus info palīgs vairs neuzrādās, ja nav papildus info.</li>
                                <li>Vārda "Beidzis" vietā izmantojam "Absolvējis".</li>
                                <lli>Repatriācijas -> Repartīcijas. Upss...</lli>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>02.03.18</h4>
                            Pagaidām pāreja uz AdminLTE ir pārcelta uz vēlāku datumu, jo bija svarīgākas lietas ko
                            darīt.<br>
                            Prioritāti ņems refaktorēšana lai izvairītos no mirušiem vai neizmantotiem datiem... <br>
                            <hr>
                            <ul>
                                <li>Old!, K!Tēva, K!Mātes piesaistīšana ar biedru reģistrācijas laikā ir mainīta.
                                    Meklēšana ir plašāka un pēc izvēles parāda Vārdu, Uzvārdu un Biedra numuru iekavās.
                                    Dēļ šīs izmaiņas labās puses lauki ir noņemti, jo tiem vairs nav īpašas nozīmes.
                                    Uzrādās arī placeholder lai ievērotu shēmu <i>Vārds Uzvārds (Biedra Numurs)</i>.
                                    Asinhrona validācija vēl nav implementēta, tādēļ jābūt uzmanīgiem ko rakstam :)
                                    Meklēšana tagad notiek 500ms pēc rakstīšanas pārtraukšanas, nevis uz katra taustiņa
                                    spiešanas.
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>28.02.18</h4><br>
                            WYSIWYG redaktors veljoprojām nestrādā mistisku iemeslu dēļ...<br>
                            Plānota pāreja no tīra Bootstrap 4 uz Bootstrap 4 + AdminLTE dashboard dizainu. Tas padarīs
                            lapu daudz tīrāku, vienkāršāku un funkcionālāku! <br>
                            <b>Par datuma izvēlnēm :</b> Nav nepieciešams tīt uz atpakaļu! Nospiežot uz mēneša
                            nosaukumu, var pāriet uz mēnešu skatu. Nos piežot uz gadu šajā skatā var pāriet uz gadu un
                            pc tam uz desmit gadu skatiem. <br>
                            <hr>
                            <ul>
                                <li>Reģistrācijas lapā ielikts placeholder telefona numura ievadei.</li>
                                <li>Ja ievadīts biedra numurs kas jau reģistrēts, tiek dota vizuāla norāde uz kļūmi.
                                </li>
                                <li>Pie teksta ar papildus info (piezīmēm) ievietots <i
                                            class="fas fa-question-circle text-primary"></i>, lai padarītu to
                                    intuitīvāku. Piemēram: <span data-toggle="tooltip"
                                                                 title="Papildus informācija par adresi">Adrese<i
                                                class="fas fa-question-circle text-primary"></i></span></li>
                                <li>Bio Piezīmju veidošana nekad nav bijusi daļa no reģistrācijas, tādēļ mainīts
                                    biogrāfijas piezīmju nosaukums uz Biedrziņa piezīmes, lai izvairītos no
                                    pārpratumiem.
                                </li>
                                <li>Biogrāfijas skatā galvenajā nodaļā kolonas paplašinātas horizontāli, lai izvairītos
                                    no nevajadzīgām pārejām jaunā rindā.
                                </li>
                                <li>Reģistrācijas lapā Old!, K!tēvs un K!māte daļā, jaunu lietotāju vārda un uzvārda
                                    lauki neuzrādas uzreiz pēc lapas ielādes.
                                </li>
                                <li>Izlabota kļūme: Adrešu piezīmes vairs NAV obligātas...</li>
                                <li>Telefona numuru validācija. Kļūmes paziņojums identisks biedra id kļūmes
                                    paziņojumam. [Paldies propaganistas/laravel-phone]
                                    <i data-toggle="tooltip"
                                       title="Sistēma automātiski atpazīst numura formātu un pārbauda telefona pareizību."
                                       class="fas fa-question-circle text-primary"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h4>27.02.18</h4><br>
                            <ul>
                                <li>Izveidota "Izmaiņas" sadaļa, lai sekotu līdzi izmaiņām</li>
                                <li>Salabots Admin BIO. Nepieciešams dzēst eksistējošo [salauzto] bio no DB.</li>
                                <li>Izlabotas kļūmes kodā kas neļāva izveidot noklusējuma datus, ja tie nebija doti.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  MODALS  -->
        <div id="modalContainer">

        </div>

        <script>
            $(document).ready(function () {
                $.ajax({
                    url: '/news/index/1',
                    type: 'GET',
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    complete: function () {
                        $('#loader').hide();
                    },
                    success: function (data) {
                        $('#news-box').html(data.html)
                    }
                });


                var timeout_page = null;
                var timeout_search = null;
                var pageField = $("#pageField");
                var pageCount = parseInt(pageField.attr('data-pagecount'));

                function dataLoader() {
                    $.ajax({
                        type: "GET",
                        url: '/news/index/' + pageField.val(),
                        beforeSend: function () {
                            $('#news-box').html('');
                            $('#loader').show();
                        },
                        complete: function () {
                            $('#loader').hide();
                        },
                        success: function (data) {
                            $('#news-box').html(data.html)
                        }
                    });
                    pageButtonOverride();
                }


                pageField.on('change', function () {
                    clearTimeout(timeout_page);
                    timeout_page = setTimeout(function () {
                        dataLoader();
                    }, 500);
                });

                function pageButtonOverride() {
                    var currentPage = pageField.val();
                    $('.page-btn').each(function (index) {
                        var x = parseInt(currentPage) + parseInt($(this).attr('data-increment'));
                        if (x < 1 || x > pageCount) {
                            $(this).parent().addClass("disabled");
                        } else {
                            $(this).parent().removeClass("disabled");
                        }

                        $(this).unbind("click");
                        $(this).on("click", function (e) {
                            e.preventDefault();
                            pageField.val(x);
                            pageField.change();
                        });
                    });
                }

                pageButtonOverride();
            });
        </script>
    </main>
@endsection