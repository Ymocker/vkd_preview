@extends('backend.layouts.master')

@section('after-scripts')
    <script type="text/javascript" src="/js/vendor/ajaxupload.3.5.js"></script>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <script type="text/javascript">
        CKEDITOR.replace('editor', {
            allowedContent:true
        });

        $(document).ready(function(){
            $("#butCipher").click(function(){
                $.ajax({
                    type: "get",
                    url: "cipher",
                    data: "pass=" + $("#pass").val(),
                    success: function(result){
                       $("#cipher").html(result);
               }});
           });

            $( "input[type=radio]" ).on( "click", function(){
                $("#editedfile").html($(this).val() + ".txt");
                $.ajax({
                    type: "get",
                    url: "about",
                    data: "file=" + $(this).val(),
                    success: function(result){
                        $("#butAbout").css('visibility', 'hidden');
                        CKEDITOR.instances['editor'].setData(result);
               }});
            });

            CKEDITOR.instances['editor'].on("key", function(){
                if ($("#editedfile").html() !== '&nbsp;') {
                    $("#butAbout").css('visibility', 'visible');
                }
            });

            $("#butAbout").click(function(){
                $.ajax({
                    type: "post",
                    url: "saveabout",
                    data: {'txt' : CKEDITOR.instances['editor'].getData(), 'file' : $("#editedfile").text(), _token : "{{ csrf_token() }}" },
                    success: function(result){
                       $("#butAbout").css('visibility', 'hidden');
                    }
                });
            });
        });
    </script>
@endsection

@section('content')
<h3 class="box-title">Настройки <small>(Внимание! Неправильные настройки могут привести к потере данных и неработоспособности сайта)</small></h3>

    {!! Form::open(['url' => 'admin/settings', 'class' => 'form-horizontal', 'role' => 'form']) !!}

        <div class="form-group form-group-lg">
            <div class="col-sm-3">
                {!! Form::label('currnom', 'Текущий номер') !!}
                {!! Form::input('number', 'currnom', $sett->currnom, ['class' => 'form-control', 'required' => true,
                'min' => 1, 'max' => 100000]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('newnom', 'Новый номер') !!}
                {!! Form::input('number', 'newnom', $sett->newnom, ['class' => 'form-control', 'required' => true,
                    'min' => 1, 'max' => 100000]) !!}
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-3">
                {!! Form::label('kolvo', 'Количество номеров') !!}
                {!! Form::input('number', 'kolvo', $sett->kolvo, ['class' => 'form-control', 'required' => true,
                    'min' => 1, 'max' => 50]) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('ksdelimiter', 'Разделитель для ключевых слов') !!}
                {!! Form::input('text', 'ksdelimiter', $sett->ksdelimiter, ['class' => 'form-control', 'required' => true,
                    'pattern' => '\D']) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('smallpic', 'Размер для миниатюр (px)') !!}
                {!! Form::input('number', 'smallpic', $sett->smallpic, ['class' => 'form-control', 'required' => true,
                    'min' => 100, 'max' => 500]) !!}
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-12">
                {!! Form::label('actia', 'Текст акции /// для отмены акции удалите все символы из данного поля') !!}
                {!! Form::input('text', 'actia', $sett->actia, ['class' => 'form-control', 'max' => 125]) !!}
            </div>
        </div>

        {!! Form::submit('Сохранить',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    <hr>

    <div class="form-group form-group-lg">
        <h4>Редактирование текстовых файлов сайта</h4>
        {{ Form::radio('aboutfile', 'about', false, ['id' => 'about']) }} about.txt<br>
        {{ Form::radio('aboutfile', 'contact', false, ['id' => 'contact']) }} contact.txt<br>
        {{ Form::radio('aboutfile', 'tariff', false, ['id' => 'tariff']) }} tariff.txt<br>
        {{ Form::radio('aboutfile', 'footer', false, ['id' => 'footer']) }} footer.txt
        <br /><b id="editedfile">&nbsp</b>
        <textarea name="editor" id="editor"></textarea>
        <p>&nbsp;</p>
        <div id="butAbout" class="btn btn-primary" style="visibility: hidden">Сохранить изменения</div>
    </div>

    <p>&nbsp;</p>
    <hr>

    <div class="col-sm-6">
        {!! Form::label('pass', 'Ввод текста для шифрования >>> ') !!}
        {!! Form::text('pass', '', ['class' => 'form-control', 'size' => 50, 'maxlength' => 20]) !!}
        <br />
        <div id="butCipher" class="btn btn-primary">Получить шифр</div>
        <h4 id="cipher">Cipher</h4>
    </div>

@endsection
