@extends('backend.layouts.master')

@section('content')
    <div class="box-header with-border">
        <h3 class="box-title">Добавить новый номер газеты. /</h3>
        Текущий номер - <b>{{ $nomer->current }}</b>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box tools -->
    </div><!-- /.box-header -->

    <div class="box-body">
        {!! Form::open(['url' => 'admin/newnumber', 'class' => 'form-horizontal', 'role' => 'form']) !!}
            <div class="form-group form-group-lg">
                {!! Form::label('next', 'Следующий номер') !!}
                <div class="col-sm-2">
                    {!! Form::input('number', 'next', $nomer->nomgaz, ['class' => 'form-control', 'min' => 1, 'max' => 100000, 'required' => true]) !!}
                </div>
            </div>

            <div class="form-group form-group-lg">
                {!! Form::label('data', 'Ввести дату выхода') !!}
                <div class="col-sm-3">
                    {!! Form::input('text', 'data', $nomer->datavyh, ['class' => 'form-control', 'placeholder' => '1 января 2016 года', 'required' => true]) !!}
                </div>
            </div>

            <div class="form-group form-group-lg">
                {!! Form::label('ynum', 'Номер газеты в году') !!}
                <div class="col-sm-2">
                    {!! Form::input('number', 'ynum', $nomer->nomgod, ['class' => 'form-control col-xs-2', 'min' => 1, 'max' => 52, 'required' => true]) !!}
                </div>
            </div>

            {!! Form::submit('Добавить',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div><!-- /.box-body -->
@endsection