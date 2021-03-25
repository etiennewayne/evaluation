<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="GADTC">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Custom fonts for this template-->
    <link href="{{ asset('css/family-nunito.css') }}" rel="stylesheet">


    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>

<body>


{{-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
    Logout
</a> --}}

{{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form> --}}

<div id="app">


    <faculty-rating code="{{$code}}"></faculty-rating>

</div>


@yield('extrascript')

</body>

</html>






