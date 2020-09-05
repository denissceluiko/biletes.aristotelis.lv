@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6 offset-lg-3">
            <h1>Dalībnieku reģistrācija</h1>
            <p>Vairāk info par studentu svētkiem meklē <a href="https://aristotelis.lv">aristotelis.lv</a>.</p>
            <div class="card">
                <div class="card-body">
                    @if($invite->isSaved())
                        <div class="alert alert-success">Ievadīts ielūgums: {{ $invite->name }}</div>
                        @if ($errors->has('invite_id'))
                            <div class="alert alert-danger">{{ $errors->first('invite_id') }}</div>
                        @endif
                    @endif
                    <h5 class="card-title">Ievadi savus datus</h5>
                    <p>Reģistrējoties saņemsi uz savu e-pastu kodu, kas būs jāuzrāda pie ieejas.</p>
                    {{ Form::open(['action' => 'PersonController@store']) }}
                        @if($invite->isSaved())
                            {{ Form::hidden('invite_id', $invite['id']) }}
                        @endif
                        <div class="form-group">
                            {{ Form::label('name', 'Vārds') }}
                            {{ Form::text('name', $invite['name'], ['class' => 'form-control mb-3', 'required']) }}
                            @if ($errors->has('name'))
                                <small class="form-text text-danger">{{ $errors->first('name') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('surname', 'Uzvārds') }}
                            {{ Form::text('surname', $invite['surname'], ['class' => 'form-control mb-3', 'required']) }}
                            @if ($errors->has('surname'))
                                <small class="form-text text-danger">{{ $errors->first('surname') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'E-pasts') }}
                            {{ Form::text('email', $invite['email'], ['class' => 'form-control mb-3', 'required']) }}
                            @if ($errors->has('email'))
                                <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('phone', 'Telefons') }}
                            {{ Form::text('phone', $invite['phone'], ['class' => 'form-control mb-3', 'required']) }}
                            @if ($errors->has('phone'))
                                <small class="form-text text-danger">{{ $errors->first('phone') }}</small>
                            @endif
                        </div>
                    {{ Form::submit('Saņemt', ['class' => 'form-control btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
            <p>Latvijas Universitātes Studentu padome veic apmeklētāju reģistrāciju un uzskaiti studentu svētkos "Aristotelis", lai ievērtotu <a href="http://likumi.lv/ta/id/315304-epidemiologiskas-drosibas-pasakumi-covid-19-infekcijas-izplatibas-ierobezosanai">09.06.2020. Ministru kabinta noteikumus Nr. 360</a>.</p>
            <p>Neskaidrību gadījumā droši raksti uz <a href="mailto:aristotelis@lusp.lv">aristotelis@lusp.lv</a> </p>
        </div>
    </div>
</div>
@endsection
