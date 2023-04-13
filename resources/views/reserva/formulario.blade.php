@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Dados do Reserva
                        <a href="{{ url('reserva') }}" class="btn btn-success btn-sm float-end">
                            Listar Reservas
                        </a>
                    </div>
                    <div class="card-body">
                        @if(Session::has('mensagem_sucesso'))
                            <div class="alert alert-success">
                                {{ Session::get('mensagem_sucesso') }}
                            </div>
                        @endif
                        @if(Session::has('mensagem_erro'))
                            <div class="alert alert-danger">
                                {{ Session::get('mensagem_erro') }}
                            </div>
                        @endif

                        @if(Route::is('reserva.show'))
                            {!! Form::model($reserva,
                                            ['method'=>'PATCH',
                                            'url'=>'reserva/'.$reserva->id]) !!}
                        @else
                            {!! Form::open(['method'=>'POST', 'url'=>'reserva']) !!}
                        @endif
                        {!! Form::label('equipamento_id', "Equipamento") !!}
                        {!! Form::select('equipamento_id',
                                         $equipamentos,
                                         null,
                                         ['class'=>'form-control',
                                         'placeholder'=>'Selecione o equipamento',
                                         'required',
                                         'autofocus']) !!}
                        {!! Form::label('local_id', "Local") !!}
                        {!! Form::select('local_id',
                                         $locais,
                                         null,
                                         ['class'=>'form-control',
                                         'placeholder'=>'Selecione o local',
                                         'required']) !!}
                        {!! Form::label('data', 'Data') !!}
                        {!! Form::input('date', 'data',
                                        null,
                                        ['class'=>'form-control',
                                        'placeholder'=>'Data',
                                        'required']) !!}
                        {!! Form::submit('Salvar',
                                        ['class'=>'float-end btn btn-primary mt-3']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
