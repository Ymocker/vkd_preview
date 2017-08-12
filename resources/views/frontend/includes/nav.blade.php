<div class="mainMenu" id="topMenu">
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/about/about">О нас</a></li>
        <li><a href="/about/contact">Контакты</a></li>
        <li><a href="/about/tariff">Тарифы</a></li>
        @if (isset($numbers))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Архив <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    @foreach ($numbers as $key => $value)
                        <li><a href="/number/{{ $key }}">Номер {{ $value[1] }} ({{ $value[0] }})</a></li>
                    @endforeach
                </ul>
            </li>
        @endif
    </ul>
</div>