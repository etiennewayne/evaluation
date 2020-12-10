@extends('layouts.student-layout')

@section('content')

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


        <div class="row">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">ATTENTION!</h4>
                <p>All courses must be rated. Please check every courses if it has been rated before logging out in the system.</p>
                <hr>
                <p class="mb-0"></p>
            </div>
        </div>

		<div class="row">

			<div class="col-md-4">

				<div class="card sticky-top">
                    <div class="card-header" style="background-color: #184725;color: white;">
                        <b>STUDENT INFORMATION</b>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Name : {{ $user->lname }}, {{ $user->fname }}</li>
                        <li class="list-group-item">Program : {{ $user->program_code }}</li>
                        <li class="list-group-item">No of Subject to Rated : {{$countrated }} / {{$countcourse}}</li>
                        <li class="list-group-item">Academic Year : {{ $ay->ay_desc }}({{$ay->ay_code}})</li>
                    </ul>
				</div>

			</div> <!-- close col md 4 -->


            <div class="col-md-8">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Schedule Code</th>
                        <th scope="col">Course Code</th>
                        <th scope="col">Course Description</th>
                        {{--                    <th scope="col">Time</th>--}}
                        {{--                    <th scope="col">Day</th>--}}
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($enrolees as $enrolee)
                        @foreach ($enrolee->schedules as $eSched)
                            <tr>
                                <th scope="row"> {{ $eSched->sched_code }}</th>
                                <td>{{ $eSched->course->course_code }}</td>
                                <td>{{ $eSched->course->course }}</td>
                                {{--                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s',$eSched->time_start)->format('h:i A')  }} - {{ \Carbon\Carbon::createFromFormat('H:i:s',  $eSched->time_end)->format('h:i A') }}</td>--}}
                                {{--                            <td>{{ $eSched->sched_day }}</td>--}}

                                @php

                                    if(\App\Rating::where('user_id', Auth::user()->user_id)->where('schedule_id', $eSched->schedule_id)->exists() > 0){
                                         echo '<td style="background-color:#ffeded; font-style: italic; text-align:center;"><a href="/studyload/viewrating/'. $eSched->schedule_id .'">View Rating</a></td>';
                                    }else{
                                        echo '<td><a class="btn btn-success" href="/studyload/schedule/'. $eSched->schedule_id .'">  RATE  </a></td>';
                                    }

                                @endphp

                            </tr>
                        @endforeach
                    @endforeach

                    </tbody>
                </table>
            </div>

    </div><!--close row-->


    </div> <!--container-->

@endsection


