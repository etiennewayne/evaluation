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
            <div class="alert alert-success" style="width:100%;" role="alert">
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
                        <li class="list-group-item">Name : {{ trim(Auth::user()->lname) }}, {{ trim(Auth::user()->fname) }}</li>
                        <li class="list-group-item">Program : {{ $user ? $user->program_code : '' }}</li>
                        <li class="list-group-item">No. of course to be rated : {{$countrated }} / {{$countcourse}}</li>
                        <li class="list-group-item">Academic year : {{ $ay->ay_desc }}({{$ay->ay_code}})</li>
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
                    @foreach ($enroleeCourses as $enrCourses)

                        @foreach ($enrCourses->schedules as $enrSchedule)
                            <tr>
                                <th scope="row"> {{ $enrSchedule->schedule_code }}</th>

                                <td>{{ $enrSchedule->course->course_name }}</td>
                                <td>{{ $enrSchedule->course->course_desc }}</td>

                                @php

                                    if(\App\Rating::where('student_id', Auth::user()->student_id)->where('schedule_code', $enrSchedule->schedule_code)->exists() > 0){
                                         echo '<td style="background-color:#ffeded; font-style: italic; text-align:center;"><a href="/cor/viewrating/'. $enrSchedule->schedule_code .'">View Rating</a></td>';
                                    }else{
                                        $hasFaculty = \DB::table('schedules as a')
                                            ->join('faculties as b', 'a.faculty_code', 'b.faculty_code')
                                            ->where('a.schedule_code',$enrSchedule->schedule_code)
                                            ->count();

                                       if($hasFaculty > 0){
                                           echo '<td><a class="btn btn-success" href="/cor/schedule/'. $enrSchedule->schedule_code .'">  RATE  </a></td>';
                                       }else{
                                            echo '<td><i>Not available</i></td>';
                                       }
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


