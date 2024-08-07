@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                <h1>Atlaide Aristotelim LU studējošajiem</h1>
                <p>Latvijas Universitātes studentiem ir iespēja iepriekšpārdošanā iegādāties biļeti Aristoteļa svētku vakara daļai par ar atlaidi. Atlaižu kodu vari saņemt uz savu <code>@students.lu.lv</code> e-pastu, aizpildot anketu zemāk.</p>
                <p>Vairāk info par studentu svētkiem meklē <a href="https://aristotelis.lv">aristotelis.lv</a>.</p>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Atlaides kodi šobrīd beigušies</h5>
                        <p>Lūdzu pamēģini vēlāk.</p>
                    </div>
                </div>
                <p>Neskaidrību gadījumā droši raksti uz <a href="mailto:aristotelis@lusp.lv">aristotelis@lusp.lv</a> </p>
            </div>
        </div>
    </div>
@endsection
