<div id="scrollPic" style="background-image: url(/siteimg/background{{ Session::get('back') }}.jpg)">
    @include('frontend.includes.nav')
    <div class="container-fluid">
    <div class="row">
        <div id="mainLogo" class="col-lg-6 col-md-5 col-sm-6">
            <div id="inMain">
                <img id="logo" src="/siteimg/biglogoop.png" alt="Газета &quot;В Каждый Дом&quot;" width="600" height="200" class="img-responsive hidden-xs" />

                <p id="advantage">
                    50&nbsp;000 семей Витебска<br />и 1&nbsp;000 организаций<br />получат Вашу рекламу!
                </p>
            </div>
        </div>

        @if ($actia != '')
            <div class="col-lg-3 col-md-4 col-sm-6 act">
                <div class="acttext">{{ $actia }}</div>
            </div>

            <div class="col-lg-3 col-md-3 hidden-xs hidden-sm rndrek">
        @else
            <div class="col-lg-3 col-sm-6 hidden-xs rndrek">
        @endif
            <a href="/ads/{{ $randRek->id }}" target="_blank">
                <div style="width:{{ $wd+10 }}px; height:{{ $wd+10 }}px">
                    <!--<div>-->
                        <img src="/img/{{ $randRek->rekname }}s.jpg" alt="...">
                    <!--</div>-->
                </div>
            </a>
        </div>
    </div>
    </div>
    <div class="mainMenu" id="bottomMenu">
        <ul>
                <li><a href="/page/1#bottomMenu">Первая&nbsp;полоса</a></li>
                <li><a href="/page/2#bottomMenu">Внутренние&nbsp;полосы</a></li>
                <li><a href="/page/4#bottomMenu">Последняя&nbsp;полоса</a></li>
                <li><a href="/page/5#bottomMenu">Текстовая&nbsp;реклама</a></li>
                <li><a href="/page/0#bottomMenu">Реклама&nbsp;на&nbsp;сайте</a></li>
                <li><a href="/page/search#bottomMenu">Поиск&nbsp;рекламы</a></li>
        </ul>
    </div>
</div>