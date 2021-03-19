@extends('layouts.student-app')

@section('content')
    <criteria-page schedule-code="{{ $schedule_code }}" ay-code="{{$ay_code}}"></criteria-page>

@endsection
