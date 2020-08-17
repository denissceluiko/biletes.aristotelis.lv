@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['action' => 'DiscountController@apply']) }}
                    <div class="form-group">
                        {{ Form::label('email', 'E-pasts', ['class' => '']) }}
                        {{ Form::text('email', null, ['class' => 'form-control mb-3', 'required']) }}
                        @if ($errors->has('email'))
                            <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                        @endif
                    </div>
                    {{ Form::submit('Pieteikties', ['class' => 'form-control btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
