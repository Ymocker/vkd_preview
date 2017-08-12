@extends('backend.layouts.master')

@section('content')
    <h3 class="box-title">E-mail и пароль администратора.</h3>

    {!! Form::open(['url' => 'admin/security', 'class' => 'form-horizontal', 'role' => 'form']) !!}

        <div class="form-group form-group-lg">
            <div class="col-sm-4">
                {!! Form::label('adminemail', 'e-mail') !!}
                {!! Form::input('email', 'adminemail', $admail, ['class' => 'form-control', 'required' => true]) !!}
            </div>
            <div class="col-sm-4">
                {!! Form::label('pass', 'Новый пароль / не менее 6 символов') !!}
                {!! Form::input('text', 'pass', '', ['class' => 'form-control', 'required' => true, 'minlength' => 6]) !!}
            </div>
        </div>

        {!! Form::submit('Сохранить изменения',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

@endsection
