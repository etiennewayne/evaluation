<!DOCTYPE html>
<html>
<head>
	
	<script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script> 
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}" />
	
</head>

<style>
	body{
		background-image: url({{ asset("img/gadtc.jpg") }});
		background-attachment: fixed;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;

	}

</style>



<body>
	
	<div class="container">
		<div class="row">
		
		  <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
			<div class="card card-signin my-5">
			  <div class="card-body">

			  	<div style="text-align: center;">
			  		<img src="{{ asset('img/logo.png') }}" height="100">
			  	</div>

			  	<div style="height: 10px; background-color: green;">
			  	</div>
			  
			  <h2 style="text-align: center;">FPES Security Check</h2>
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

				 <!-- <div class="custom-control custom-checkbox mb-3">
					<input type="checkbox" class="custom-control-input" id="customCheck1">
					<label class="custom-control-label" for="customCheck1">Remember password</label>
				  </div> -->
				  <button style="background-color: green; color: white;" class="btn btn-lg btn-block text-uppercase" type="submit">Sign in</button>
				  <hr class="my-4">
				<!--  <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign in with Google</button>
				  <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook</button> -->
					@if(session('pwderror'))
						<p style="color:red;">{{ session('pwderror') }}</p>
					@endif
					
				</form>
			  </div>
			</div>
		  </div>
		  
		  
		</div>
	 </div>

</body>




</html>

