<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Print {{ $diary['title']}}</title>


    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    {{-- Dropify --}}
    <script src="{{ asset('js/dropify.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- SB Admin Assets --}}
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0371f381a6.js" crossorigin="anonymous"></script>
</head>
<body>
    <img src="{{ asset('assets/images/cdl-logo.png') }}" alt="CDL Logo" width="30%">
    <div class="container">
        </div>
        <div class="card-body">
            <div class="header-box py-3 border-bottom mb-3">
                <h3 class="text-uppercase bg-primary p-2 text-light mb-3">Practicum Duty Diary</h3>
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
            <h5 class="text-uppercase">Plan Today</h5>
            {!! $diary['diary']->plan_today !!}
            <hr>
            <h5 class="text-uppercase">End-of-Day Report</h5>
            {!! $diary['diary']->end_today !!}
            <hr>
            <h5 class="text-uppercase">Plan Tomorrow</h5>
            {!! $diary['diary']->plan_tomorrow !!}
            <hr>
            <h5 class="text-uppercase">Roadblocks</h5>
            {!! $diary['diary']->roadblocks !!}
            <hr>

            <h5 class="text-uppercase">Summary</h5>
            {!! $diary['diary']->summary !!}
            <hr>
            <p class="mt-5">Checked by:</p>
            <h5 class="mt-5 text-uppercase m-0">{{$diary['supervisor'] }}</h5>
            <p class="m-0">HTE Supervising Officer</p>
            <p class="m-0">Date: {{ now()->format('md/y') }}</p>
        </div>
    </div>

    <script>
        $(function(){
            printPage();            
        })
    </script>


    <script>
        function printPage(){
            window.print();
            window.onafterprint = function(){
                window.close();
            }
        }
    </script>
</body>
</html>
    