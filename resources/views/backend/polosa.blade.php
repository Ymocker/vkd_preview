@extends('backend.layouts.master')

@section('after-scripts')
    <script>
        function confirmDel (obj) {
            if (confirm("Удалить рекламу ID = " + obj.getAttribute('value') + " ?") === true) {
                window.location.href = "/admin/rek/" + obj.getAttribute('value') + "/delete/{{ $polosa }}";
            }
        }
    </script>
@endsection

@section('content')
    <h3 class="box-title">
        @if ($polosa == 999)
            Реклама в АРХИВЕ
        @else
            Реклама на полосе {{ $polosa }}
        @endif
    </h3>

    @foreach ($reklama as $rek)
        <div class="rek-thumb" style="width:{{ $admData['wd']+10 }}px; height:{{ $admData['wd']*2 }}px">
            <div class="thmb-img" style="width:{{ $admData['wd'] }}px; height:{{ $admData['wd']+10 }}px">
                <img src="/img/{{ $rek->rekname }}s.jpg" alt="...">
            </div>
            <div class="thmb-info">
                <p>Реклама(ID): {{ $rek->id }}<br />
                Имя: {{ $rek->rekname }}<br />
                Номер(ID): {{ $rek->nomer_id }}<br />
                Полоса: {{ $rek->polosa }}</p>
            </div>
            <div class="btn-group">
                @if ($polosa != 999)
                    <a href="/admin/rek/{!! $rek->id !!}/edit" class="btn btn-s btn-primary" title="Редактировать"><i class="fa fa-pencil"></i></a>
                    <a href="/admin/rek/{!! $rek->id !!}/arch/{{ $polosa }}" class="btn btn-s btn-primary" title="В архив"><i class="fa fa-folder-open"></i></a>
                @else
                    <a href="/admin/rek/{!! $rek->id !!}/arch/999" class="btn btn-s btn-primary" title="Восстановить"><i class="fa fa-share"></i></a>
                @endif
                <a class="btn btn-s btn-danger" onclick="confirmDel(this)" value="{!! $rek->id !!}" title="Удалить"><i class="fa fa-times"></i></a>
            </div>
        </div>
    @endforeach

@endsection