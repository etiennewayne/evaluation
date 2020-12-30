<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('EVALUATION SYSTEM') }}</title>

    <script type="text/javascript" src="{{asset('/js/jquery-3.3.1.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css") }}" />

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

</head>

<body>



<nav class="navbar navbar-expand-lg navbar-custom fixed-top navbar-light">

    <a class="navbar-brand" href="/home">
        <div class="logo-container">
            <div class="logo-col1">
                <img src="{{ asset('img/logo.png') }}" height="60">
            </div>

            <div class="logo-col2">
                <div class="a-element-long">Faculty Performance Evaluation System</div>
                <div class="a-element-short">FPES</div>
                <div class ="b-element-long">Gov. Alfonso D. Tan College</div>
                <div class ="b-element-short">GADTC</div>
            </div>
        </div>
    </a>

    <button class="navbar-toggler" style=" " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">

            <li class="nav-item {{ (request()->is('home') || (request()->is('/'))) ? 'active' : '' }}">
                <a class="nav-link" href="/home">Home</a>
            </li>


            @if(Auth::check())
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                        @php
                            $lname = Auth::user()->lname;
                            $fname = Auth::user()->fname;
                        @endphp

                        {{ $fname[0] }}{{ ucfirst($lname) }} ({{Auth::user()->username}})  <span class="caret"></span>

                    </a>



                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="/change-password">Change Password</a>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>

            @endif

        </ul>

        <!-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->

    </div>
</nav>


<br>


<div class="container">


    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCCESS!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>WARNING!</strong> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif




    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="/change-password">
                        @csrf

                        <div class="form-group row">
                            <label for="oldpassword" class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                            <div class="col-md-6">
                                <input id="oldpassword" type="password" class="form-control @error('oldpassword') is-invalid @enderror" name="oldpassword" value="{{ old('oldpassword') }}" required autocomplete="off" autofocus>

                                @error('oldpassword')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="npassword" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="npassword" type="password" class="form-control @error('npassword') is-invalid @enderror" name="npassword" value="{{ old('npassword') }}" required autocomplete="off" autofocus>

                                @error('npassword')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rpassword" class="col-md-4 col-form-label text-md-right">{{ __('Confrim Password') }}</label>
                            <div class="col-md-6">
                                <input id="rpassword" type="password" class="form-control @error('rpassword') is-invalid @enderror" name="rpassword" value="{{ old('rpassword') }}" autocomplete="off" autofocus>

                                @error('rpassword')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<footer class="footer myfooter">
    <div class="container">
        <span class="text-center">© 2020 Copyright: Gov. Alfonso D. Tan College</span>
    </div>
</footer>

<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>

<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>


</body>
</html>





