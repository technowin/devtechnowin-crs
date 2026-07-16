<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{asset('img/favicon-thatday.png')}}"/>
    <title>{{ config('app.name', 'OLS') }}</title>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('jasny-bootstrap/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/body-padding.css')}}" rel="stylesheet">
    <link href="{{asset('github/frameworks.css')}}" rel="stylesheet">
    <link href="{{asset('carousel/carousel.css')}}" rel="stylesheet">
    <style>body {
            padding-top: 70px;
        }</style>
</head>
<body>
<div class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'CRS') }}
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav pull-right">
                @if (Route::has('login'))
                    @auth
                    <li><a href="{{ url('/home') }}">Home</a></li>
                @else
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    {{--                            <li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            {{--<h3 class="text-center text-muted">Complaint Redressal System</h3>--}}
            <h3 class="text-center text-muted">TECHNOWIN IT INFRA PVT LTD</h3>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="http://placehold.it/1500x400/16a085/ffffff&text=About Us">
                        </br>
                        <div class="carousel-caption">
                            <p>
                                We at Technowin IT Infra, adopt latest technologies with high value performance,
                                that is bound to give full satisfaction to all our valued customers.
                                We at TECHNO WIN, are a group of technically sound computer professionals engaged primarily in computer enabled services including Hardware And Networking,
                                Data Management Services and Software Development.
                            </p>
                        </div>
                    </div>
                    <!-- End Item -->
                    <div class="item">
                        <img src="http://placehold.it/1500x400/e67e22/ffffff&text=Projects">
                        </br>
                        <div class="carousel-caption">
                            <p>
                                Data Management System(DMS), Payroll Management System, CIDCO Data Entry Suite, Complaint Redressal System, Tender Management
                                System</p>
                        </div>
                    </div>
                    <!-- End Item -->
                    <div class="item">
                        <img src="http://placehold.it/1500x400/2980b9/ffffff&text=Portfolio">
                        </br>
                        <div class="carousel-caption">
                            <p>
                                Municipal Corporation of Greater Mumbai (Recruitment of Candidates for post of Security Guards),
                                Municipal Co-Operative Bank (Hardware and Network Sale and maintenance),
                                MHADA (Data Entry and Scanning of Tenants and Occupant files),
                                BEST (Traffic, Pension, EDP) (Hardware and Network Sale and maintenance),
                                CIDCO (Data Capture Software and Data Entry Management)</p>
                        </div>
                    </div>
                    <!-- End Item -->
                    <div class="item">
                        <img src="http://placehold.it/1500x400/8e44ad/ffffff&text=Services">
                        </br>
                        <div class="carousel-caption">
                            <p>Data And Digitization of Documents, Hardware, Software Supply and Maintenance, Network, Firewall and Server Administration, Software Development and Implementation, Software Support and Maintenance, IT Consulting and Operations Management</p>
                        </div>
                    </div>
                    <!-- End Item -->
                </div>
                <!-- End Carousel Inner -->
                <ul class="nav nav-pills nav-justified">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#"><strong>About</strong><small>&nbsp;&nbsp;&nbsp;</small></a></li>
                    <li data-target="#myCarousel" data-slide-to="1"><a href="#"><strong>Projects</strong><small>&nbsp;&nbsp;&nbsp;</small></a></li>
                    <li data-target="#myCarousel" data-slide-to="2"><a href="#"><strong>Portfolio</strong><small>&nbsp;&nbsp;&nbsp;</small></a></li>
                    <li data-target="#myCarousel" data-slide-to="3"><a href="#"><strong>Services</strong><small>&nbsp;&nbsp;&nbsp;</small></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <p class="navbar-text pull-left">© 2018 - techno-win@hotmail.com </p>
    </div>
</div>
<script src="{{asset('jquery/jquery-1.12.4.js')}}"></script>
<script src="{{asset('bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>
<script src="{{asset('jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('carousel/carousel.js')}}"></script>
</body>
</html>
