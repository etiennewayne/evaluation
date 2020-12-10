<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta name="csrf-token" content="{{ csrf_token() }}">

	
	<title>{{ __('EVALUATION SYSTEM') }}</title>
	
	<script type="text/javascript" src="{{asset('/js/jquery-3.3.1.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/jquery-confirm.js/')}}"></script>

	<link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css") }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset("/css/jquery-confirm.css") }}" />
	<link rel="stylesheet" type="text/css" href=" {{ asset("/css/dataTables.bootstrap4.min.css") }} ">
	<link rel="stylesheet" type="text/css" href=" {{ asset("/css/buttons.dataTables.min.css") }} ">
	 
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" />

	<style type="text/css">
	.btn-edit{
		background-image: url('{{ asset('img/edit.png') }}');
		height: 30px;
		width: 20px;
		background-repeat: no-repeat;
		background-size: contain;
	}

	.btn-delete{
		background-image: url('{{ asset('img/delete.png') }}');
		height: 30px;
		width: 20px;
		background-size: contain;
		background-repeat: no-repeat;
	}

</style>

	 
</head>

<body>
		
	<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
	
	  <a class="navbar-brand" href="/cpanel-home">FPES</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
			  
			  <li class="nav-item {{ (request()->is('cpanel-home')) ? 'active' : '' }}">
				<a class="nav-link" href="/cpanel-home">Home <span class="sr-only">(current)</span></a>
			  </li>

			  <li class="nav-item {{ (request()->is('cpanel-category')) ? 'active' : '' }}">
				<a class="nav-link" href="/cpanel-category">Category</a>
			  </li>
			  
			  <li class="nav-item {{ (request()->is('cpanel-criteria')) ? 'active' : '' }}">
				<a class="nav-link" href="/cpanel-criteria">Criteria</a>
			  </li>


			  
			  {{-- <li class="nav-item  dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Dropdown
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#">Action</a>
				  <a class="dropdown-item" href="#">Another action</a>
				  <div class="dropdown-divider"></div>
				  <a class="dropdown-item" href="#">Something else here</a>
				</div>
			  </li> --}}
			 
			    <li class="nav-item {{ (Request::route()->getName() == 'report') ? 'active' : '' }} dropdown">
				  	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  	  Report
				  	</a>
				  	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  	  <a class="dropdown-item" href="/cpanel-report-faculty">Faculty</a>
				  	  <a class="dropdown-item" href="/cpanel-report-student">Student</a>
				  	  {{-- <a class="dropdown-item" href="#">Another action</a>
				  	  <div class="dropdown-divider"></div>
				  	  <a class="dropdown-item" href="#">Something else here</a> --}}
				  	</div>
			    </li>
			  
				<li class="nav-item {{ (Request::route()->getName() == 'cpanel-users.index') ? 'active' : '' }} dropdown">
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						{{ ucfirst(Auth::user()->username) }} <span class="caret"></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="/cpanel-users">Users</a>

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

			</ul>
			
			<!-- <form class="form-inline my-2 my-lg-0">
			  <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form> -->
			
		</div>
	</nav>
	<br><br>
	
	  @yield('content')

<br><br>

	<footer class="footer myfooter">
		<div class="container">
			<span class="text-center">© 2020 Copyright: GADTC CISO</span>
		</div>
	</footer>


	<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/dataTables.buttons.min.js')}}"></script>

	@yield('extrascript')
	{{--<script type="text/javascript" src="{{asset('/js/bootstrap.min.js')}}"></script>--}}
	{{--<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>--}}
	
	
</body>
</html>

