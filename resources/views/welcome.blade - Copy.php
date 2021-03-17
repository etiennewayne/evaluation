@extends('layouts.student-layout')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}" />


    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="display-5">WELCOME TO FACULTY PERFORMANCE EVALUATION SYSTEM (FPES)</h3>
                    <p class="lead">An Assessment of teacher's performance that aims to measure teacher's competence. Produce fast, secure and reliable result where disclosure of ratings is strictly prohibited.</p>

                    @if(Auth::check())
                        <a class="btn btn-success btn-lg" href="/cor" role="button">Start Evaluation</a>
                        <br>
                        <br>
                    @endif

                </div> <!--close col-md-8-->



                <div class="col-lg-4">
                    <div class="card card-signin">
                        <div class="card-body">

                            <div style="text-align: center;">
                                <img src="{{ asset('img/logo.png') }}" height="100">
                            </div>

                            <div style="height: 10px; background-color: #184725;">

                            </div>

                            <h2 style="text-align: center;">FPES Security Check</h2>


                            @if(Auth::check())
                                <div class="alert alert-success" role="alert">
                                    Hi {{ trim(auth()->user()->lname)  }}, {{ trim(auth()->user()->fname)  }}
                                </div>

                                <div class="alert alert-warning" role="alert">
                                    <b>Note</b> : We, encourage you to change password from default to keep your rating secret.
                                </div>
                            @else


                                <h5 class="card-title text-center">Sign in</h5>
                                <form class="form-signin" method="POST" action="/login">
                                    @csrf

                                    <div class="form-label-group">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Username/ID number" required autofocus autocomplete="off" />
                                        <label for="username">Username/ID number</label>
                                    </div>

                                    <div class="form-label-group">
                                        <input type="password"name="password" id="password" class="form-control" placeholder="Password" required>
                                        <label for="password">Password</label>
                                    </div>


                                    <button style="background-color: green; color: white;" class="btn btn-lg btn-block text-uppercase" type="submit">Sign in</button>
                                    <hr class="my-4">

                                    @if(session('pwderror'))
                                        <p style="color:red;">{{ session('pwderror') }}</p>
                                    @endif


                                </form>

                            @endif

                        </div>

                    </div><!-- card sign in -->
                </div> <!-- end col md 4 -->
            </div>
        </div>





    </div>




@endsection


