@extends('layouts.student-app')

@section('content')

    @if ($errors->any())
        <login-page error="{{ $errors->all()[0] }}"></login-page>
    @else
        <login-page error=""></login-page>
    @endif


@endsection


