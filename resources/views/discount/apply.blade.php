@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        Ataides kods aizsūtīts uz {{ request('email') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
