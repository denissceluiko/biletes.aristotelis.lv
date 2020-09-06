@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6 offset-lg-3">
            <h1>Aristoteļa ielūgums</h1>
            @if($person->invite)
                <h4>{{ $person->invite->name }}</h4>
            @endif
            <h5>{{ $person->name }} {{ $person->surname }}</h5>
            <div class="card">
                <img class="card-img" src="{{ $person->qrCode() }}">
            </div>
            <p>Latvijas Universitātes Studentu padome veic apmeklētāju reģistrāciju un uzskaiti studentu svētkos "Aristotelis", lai ievērtotu <a href="http://likumi.lv/ta/id/315304-epidemiologiskas-drosibas-pasakumi-covid-19-infekcijas-izplatibas-ierobezosanai">09.06.2020. Ministru kabinta noteikumus Nr. 360</a>.</p>
            <p>Neskaidrību gadījumā droši raksti uz <a href="mailto:aristotelis@lusp.lv">aristotelis@lusp.lv</a> </p>
        </div>
    </div>
</div>
@endsection
