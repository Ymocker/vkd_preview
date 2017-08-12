@extends('backend.layouts.master')

@section('after-scripts')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("editor", {
            allowedContent:true
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#butSave").click(function(){
                $.ajax({
                    type: "post",
                    url: "savetext",
                    data: {"txt" : CKEDITOR.instances["editor"].getData(), _token : "{{ csrf_token() }}"}
                })
                    .done(function(result) {
                        $("#butSave").css("visibility", "hidden");
                    })
                    .fail(function() {
                        alert( "error" );
                    })
                    .always(function() {
                        //alert( "ALL WAYS" );
                    });
            });

            CKEDITOR.instances["editor"].on("key", function(){
                $("#butSave").css("visibility", "visible");
            });
        });
    </script>
@endsection

@section('content')
    <h3 class="box-title">Файл текстовых объявлений.</h3>

    {!! Form::open(['url' => 'admin/addtext', 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true']) !!}
        <div class="form-group form-group-lg">
            <div class="col-sm-4">
                {!! Form::label('name', 'Файл') !!}
                {!! Form::file('file_name') !!}
            </div>
        </div>

        {!! Form::submit('Загрузить новый файл',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    @if ($txtFile === '')
        <textarea name="editor" id="editor"></textarea>
    @else
        <textarea name="editor" id="editor">{!! $txtFile !!}</textarea>
    @endif
    <div id="butSave" class="btn btn-warning" style="visibility: hidden">Сохранить изменения</div>

@endsection
