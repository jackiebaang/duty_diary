@extends('layouts.public')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 col-12">
                    <h4 class="m-0">
                        <i class="fas fa-solid fa-book-open"></i>
                        {{ $diary['title']}}
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="header-box py-3 border-bottom mb-3">
                <h3 class="text-uppercase bg-primary p-2 text-light">Duty Diary</h3>
                <div class="row pl-2">
                    <div class="col-3">Name of Trainee: </div>
                    <div class="col-9 font-weight-bold">{{ $diary['name'] }}</div>
                </div>
                <div class="row pl-2">
                    <div class="col-3">Company Name: </div>
                    <div class="col-9 font-weight-bold">CREATIVEDEVLABS (CDL INNOVATIVE IT SOLUTIONS)</div>
                </div>
                <div class="row pl-2">
                    <div class="col-3">Diary Date: </div>
                    <div class="col-9 font-weight-bold">{{ $diary['diary']->created_at->format('m/d/y') }}</div>
                </div>
            </div>
            <h5 class="text-uppercase font-weight-bold">Plan Today</h5>
            {!! $diary['diary']->plan_today !!}
            <hr>
            <h5 class="text-uppercase font-weight-bold">End-of-Day Report</h5>
            {!! $diary['diary']->end_today !!}
            <hr>
            <h5 class="text-uppercase font-weight-bold">Plan Tomorrow</h5>
            {!! $diary['diary']->plan_tomorrow !!}
            <hr>
            <h5 class="text-uppercase font-weight-bold">Roadblocks</h5>
            {!! $diary['diary']->roadblocks !!}
            <hr>

            <h5 class="text-uppercase font-weight-bold">Summary</h5>
            {!! $diary['diary']->summary !!}
            <hr>

            <h5 class="text-uppercase font-weight-bold">Diary Photo</h5>
            @if ($diary['diary']->photo != null)
                <img src="{{ asset('storage/uploads/diary-photo/'.$diary['diary']->photo) }}" width="100%">    
            @else
                <div class="alert alert-secondary">No image upload.</div>
            @endif
            
            <h5 class="mt-5 text-uppercase m-0">{{$diary['supervisor'] }}</h5>
            <p class="m-0">HTE Supervising Officer</p>
            <p class="m-0">Date: {{ now()->format('m/d/y') }}</p>
        </div>
    </div>
@endsection