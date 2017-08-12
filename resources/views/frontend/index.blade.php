@extends('frontend.layouts.master')

@section('content')

<div class="zag">
    <h4>{{ $section }}</h4>
</div>
<div class="row">
    @if ($section == 'Текстовая&nbsp;реклама')
        <div class="col-lg-7 col-md-8 col-xs-12 textrek">
            {!! $reklama !!}
        </div>
    @elseif ($section == 'Поиск&nbsp;рекламы')
        <div class="col-xs-12 search">
            @foreach ($reklama->chunk($wd) as $chunk)
                <div class="col-md-4">
                    @foreach ($chunk as $kw)
                        <a href="/search/{{ $kw['id'] }}#bottomMenu">
                            {{ $kw['kword'] }}
                        </a><br />
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <div class="col-lg-7 col-md-8 col-xs-12">
            @foreach ($reklama as $rek)
                <div class="col-md-4">
                    <a href="/ads/{{ $rek->id }}" target="_blank">
                    <div class="rek-thumb" style="width:{{ $wd+10 }}px; height:{{ $wd+10 }}px">
                        <div>
                            <img src="/img/{{ $rek->rekname }}s.jpg" alt="...">
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    @if ($section != 'Поиск&nbsp;рекламы')
        <div class="col-lg-5 col-md-4 col-xs-12">
            <div id="informer">
                {!! $viewData['informer'] !!}
            </div> <!-- informer -->
        </div>
    @endif

</div>

@endsection

