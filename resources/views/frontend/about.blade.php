@extends('frontend.layouts.aboutmaster')

@section('content')

<div class="row">
    <p>&nbsp;</p>
    <div class="col-lg-2 col-md-4 col-xs-12">
        <img src="/siteimg/biglogoop.png" alt="Газета &quot;В Каждый Дом&quot;" width="200" height="70" />
    </div>
    <div class="col-lg-10 col-md-8 col-xs-12 about">
        {!! $data !!}
        @if ($backform)
            {!! Form::open(['url' => '/about/send/message', 'id' => 'contactForm',  'role' => 'form']) !!}
                <div class="row">
                    <div class="form-group col-sm-4">
                        {!! Form::label('name', 'Ваше&nbsp;имя*') !!}
                        {!! Form::input('text', 'name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Имя']) !!}
                    </div>
                    <div class="form-group col-sm-4">
                        {!! Form::label('phone', 'Телефон') !!}
                        {!! Form::input('text', 'phone', null, ['class' => 'form-control', 'placeholder' => 'Телефон']) !!}
                    </div>
                    <div class="form-group col-sm-4">
                        {!! Form::label('email', 'E-mail*') !!}
                        {!! Form::input('text', 'email', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'e-mail']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('message', 'Сообщение*') !!}
                    {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 5, 'required' => true, 'placeholder' => 'Сообщение']) !!}
                </div>

                {!! Form::submit('Отправить',['class' => 'btn btn-primary pull-right', 'id' => 'form-submit']) !!}
                <div id="msgSubmit" class="h3 text-center">&nbsp;</div>
            {!! Form::close() !!}
        @endif
    </div>
</div>

@endsection

@section('after-scripts')

<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
        //if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $("#contactForm").on('submit', function () {
            $('#form-submit').prop('disabled', true);
            $("body").css("cursor", "progress");

            $.ajax({
                type: "POST",
                url: "/about/send/message",
                data: {
                    "_token": $( this ).find( 'input[name=_token]' ).val(),
//                    "_token" : "{{ csrf_token() }}",
                    "name": $( '#name' ).val(),
                    "phone": $( '#phone' ).val(),
                    "email": $( '#email' ).val(),
                    "message": $( '#message' ).val()
                }
            })
            .done(function(result) {  //result
                $("#contactForm").trigger( "reset" );
                setTimeout(function () {
                    $("#msgSubmit").text("Сообщение отправлено");
                    $("body").css("cursor", "default");
                }, 1000);
            })
            .fail(function() {
                $("body").css("cursor", "default");
                alert("Ошибка. Попытайтесь отправить сообщение позже.");
            })
            .always(function() {
                $("#contactForm").trigger( "reset" );
                setTimeout(function () {
                    $("#msgSubmit").text(" ");
                    $("#form-submit").prop("disabled", false);
                }, 7000);
            });
            return false;

        });

    } );

</script>
@endsection
