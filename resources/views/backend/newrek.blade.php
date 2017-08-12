@extends('backend.layouts.master')

@section('after-scripts')
    <script type="text/javascript" src="/js/vendor/ajaxupload.3.5.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var button = $("#butUpload"), interval, file;
            new AjaxUpload(button, {
                action: "picupload",
                data: {_token : "{{ csrf_token() }}"},
                name: "userfile",
                //_token : "{{ csrf_token() }}",
                onSubmit: function(file, ext){
                    if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    // extension is not allowed
                        button.text('Форматы JPG, PNG или GIF');
                        return false;
                    }
                    button.text("Загрузка");
                    this.disable();

                    var text = button.text();
                    if(text.length < 11){
                        button.text(text + ".");
                    }else{
                        button.text("Загрузка");
                    }
                },
                onComplete: function(file, response){
                    if(response==="error"){
                        $("#fileUpload").html("Файл не загружен");
                    } else {
                        button.text("Заменить");
                        var fileInfo = JSON.parse(response);

                        $("#fileImg").html('<img src="/img/tmp/'+'work.'+fileInfo.ext+'?'+Math.random()+'" alt=""/><br />');

                        //$("#fileImg").html('<img id="loadPic" src="" alt=""/><br />');
                        //$("#loadPic").attr('src','/img/tmp/'+'work.jpg?'+Math.random());

                        $("#fileInfo").html(fileInfo.name + ' / ' + fileInfo.type + ' / ' + fileInfo.size + ' / ' + fileInfo.dimensions);
                    }
                    this.enable();
                }
            });
        });

        function checkKs() {
            var sel = $("#kw :selected").map(function(){ return this.text }).get().join("{{ $delimiter }} ");
            //sel = $("#kw :selected").text();
            $("#kscontrol").html(sel);
        }

    </script>
@endsection

@section('content')

    <h3 class="box-title">Добавить новый рекламный блок.</h3>

    <div class="form-group form-group-lg">
        <div id="butUpload" class="btn btn-primary">Выбрать файл</div>
        <div id="fileImg"></div>
        <div id="fileInfo"></div>
    </div>

    {!! Form::open(['url' => 'admin/add', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <div class="form-group form-group-lg">
            <div class="col-sm-2">
                {!! Form::label('razmer', 'Размер изображения') !!}
                {!! Form::select('razmer', ['800' => '800', '1000' => '1000', '1200' => '1200', '0' => 'Другой размер'], null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-2">
                {!! Form::label('mrazmer', 'Другой размер') !!}
                {!! Form::input('number', 'mrazmer', 777, ['class' => 'form-control', 'min' => 400, 'max' => 2000]) !!}
            </div>
        </div>

        <div class="form-group form-group-lg">
            <div class="col-sm-4">
                {!! Form::label('name', 'Название') !!}
                {!! Form::input('text', 'name', '', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Name of ad']) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label('polosa', 'Полоса') !!}
                {!! Form::select('polosa', ['1' => 'Первая', '2' => 'Внутренние', '4' => 'Четвертая', '0' => 'Только на сайте'], 1, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-4">
                {!! Form::label('kw', 'Ключевые слова') !!}
                {!! Form::select('kw[]', $kw, null, ['class' => 'form-control', 'id' => 'kw', 'multiple' => 'multiple', 'size' => '10', 'onchange' => 'checkKs()']) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label('kscontrol', 'Выбранные ключевые слова') !!}
                {!! Form::textarea('kscontrol', '', ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => 10]) !!}
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-8">
                {!! Form::label('newks', 'Добавить ключевые слова (если нужно), разделяя символом « ' . $delimiter . ' »') !!}
                {!! Form::input('text', 'newks', '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-8">
                {!! Form::label('ooo', 'Название документа с расширением. Например: statia.pdf') !!}
                {!! Form::input('text', 'ooo', '', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-8">
                {!! Form::label('web', 'WEB адрес (если нужно)') !!}
                {!! Form::input('text', 'web', '', ['class' => 'form-control', 'placeholder' => 'www']) !!}
            </div>
        </div>

        {!! Form::submit('Добавить',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
