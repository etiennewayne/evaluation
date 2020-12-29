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

			  <li class="nav-item {{ (request()->is('about')) ? 'active' : '' }}">
                <a class="nav-link" href="/about">About</a>
              </li>

			  <li class="nav-item {{ (request()->is('faq')) ? 'active' : '' }}">
                <a class="nav-link" href="/faq">FAQ</a>
              </li>


                @if(Auth::check())
                    <li class="nav-item {{ (request()->is('cor*')) ? 'active' : '' }}">
                        <a class="nav-link" href="/cor">Certificate of Registration</a>
                    </li>




					 <li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							Courses To Rate
								<span class="badge badge-warning">
									{{ count($coursesNoRate) }}
								</span>

							<span class="caret"></span>

						</a>



						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							@foreach($coursesNoRate as $courseNoRate)
								<a class="dropdown-item" href="/studyload/schedule/{{ $courseNoRate->schedule_code }}">
									<b>{{ $courseNoRate->schedule_code }}</b> - {{ $courseNoRate->course_name }}
								</a>
							@endforeach

						</div>
					</li>

                @endif



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


@yield('content')

<br><br>
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

