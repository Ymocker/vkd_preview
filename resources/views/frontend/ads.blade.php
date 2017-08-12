@extends('frontend.layouts.adsmaster')

@section('content')

<div class="row" id="rowAdblck">
    <div class="col-xs-12" id="adblck">
        <hr>
        <p>Реклама в номере {{ $nomer->nomgod }}({{ $nomer->nomgaz }}) от {{ $nomer->datavyh }}</p>

        @if ($reklama->dopinf != '')
            <iframe id="ifr" src="http://docs.google.com/viewer?url=http://vkd.by/article/{{ $reklama->dopinf }}&embedded=true" width="100%" height="100%"></iframe>
        @elseif ($reklama->web != '')
            <h4><a href="http://{{ $reklama->web }}"><p>Сайт рекламодателя http://{{ $reklama->web }}</p>
            <img class="img-responsive" src="/img/{{ $reklama->rekname }}.jpg" alt="..."></a><h4>
        @else
            <img class="img-responsive" src="/img/{{ $reklama->rekname }}.jpg" alt="...">
        @endif
    </div>
</div>

@endsection

@section('after-scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $("#ifr").height($(window).height());
    });
</script>
@endsection