@extends('layouts.default')
@section('title')
Welcome
@stop

@section('content')
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <h2><i class="fa fa-lock"></i> Login</h2>
        @if($errors->has())
            @foreach ($errors->all() as $err)
                <div class="bg-danger alert">{{ $err }}</div>
            @endforeach
        @endif

        {{ Form::open(array('role' => 'form')) }}
        <div class="form-group">
            {{ Form::label('username', 'Username') }}
            {{ Form::text('username', null, array('placeholder'=> 'Username', 'class'=>'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', array('placeholder'=> 'Password', 'class'=>'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
        </div>

        {{ Form::close() }}
    </div>
</div>
@stop