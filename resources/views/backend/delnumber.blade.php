@extends('backend.layouts.master')

@section('content')
    <h3 class="box-title">Изменить текущий номер газеты.</h3>

    <div class="box-body">
        @if ($newnomer == 0)
            <h1>Нечего удалять</h1>
        @else
            <h3>Новый номер {{ $newnomer }} станет текущим.</h3>
            <h3>Номер {{ $nomer }} будет удален.</h3>
            <h3>Текущий номер {{ $arch }} станет архивным.</h3>

            <div id="butDel" class="btn btn-danger" onclick="confirmDel()" value="{{ $newnomer }}">Изменить текущий номер</div>
        @endif
    </div><!-- /.box-body -->
@endsection

@section('after-scripts')
    <script>
    function confirmDel () {
        if (confirm("Сделать номер" + " {{ $newnomer }} текущим. Подтвердите.") === true) {
            window.location.href = "delnumberscript";
        }
    }
    </script>
@endsection