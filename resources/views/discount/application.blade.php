@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6 offset-lg-3">
            <h1>Atlaide Aristotelim LU studējošajiem</h1>
            <p>Latvijas Universitātes studentiem ir iespēja iepriekšpārdošanā iegādāties biļeti Aristoteļa svētku vakara daļai par 7€. Atlaižu kodu vari saņemt uz savu <code>@student.lu.lv</code> vai <code>@lu.lv</code> e-pastu, aizpildot anketu zemāk.</p>
            <p>Vairāk info par studentu svētkiem meklē <a href="https://aristotelis.lv">aristotelis.lv</a>.</p>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Saņem savu atlaides kodu</h5>
                    {{ Form::open(['action' => 'DiscountController@apply']) }}
                    <div class="form-group">
                        {{ Form::label('email', 'E-pasts', ['class' => '']) }}
                        {{ Form::text('email', null, ['class' => 'form-control mb-3', 'required']) }}
                        @if ($errors->has('email'))
                            <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                        @endif
                    </div>
                    {{ Form::submit('Saņemt', ['class' => 'form-control btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
            <p>Neskaidrību gadījumā droši raksti uz <a href="mailto:aristotelis@lusp.lv">aristotelis@lusp.lv</a> </p>
        </div>
    </div>
</div>
@endsection
