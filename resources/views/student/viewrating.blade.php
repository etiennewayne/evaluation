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
             <strong>ERROR!</strong> {{ session('success') }}
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
        @endif

        @if(session('warning'))
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
             <strong>ERROR!</strong> {{ session('warning') }}
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
        @endif


        <div class="row justify-content-center">

            <img src="{{ asset('img/logo.png') }}" height="100">

            <div class="justify-content-center">
                <p style="margin: 0; margin-top: 20px;" class="text-center">TEACHING PERFORMANCE</p>
                <p style=";" class="text-center">{{ $ay->ay_desc }}</p>
            </div>

        </div>


        <div class="row justify-content-center">

            <div class="col-md-6">

                @php
                    $name = '';
                    $sched_code = '';
                    $course_code = '';
                    $course = '';
                    $instructor = '';

                    foreach($data as $info){
                        $name = $info->lname . ', ' . $info->fname . ' ' . $info->mname;
                        $sched_code = $info->schedule_code;
                        $course_code = $info->course_code;
                        $course = $info->course_name;
                        $instructor = $info->f_lname. ', ' .$info->f_fname;
                    }
                @endphp
                 <h4>Rating</h4>
                 <div>
                    Faculty : {{$name }}
                 </div>
                 <div>
                    Schedule/Course Code : {{ $sched_code }} ({{ $course }})
                 </div>
                 <div>
                    Course : {{ $course }}
                 </div>
                <div>
                    Instructor : {{ $instructor }}
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>

                            <th scope="col">Category</th>
                            <th scope="col">Average</th>

                        </tr>

                        @foreach($data as $category)
                            <tr>

                                <td>{{ $category->category }}</td>
                                <td>{{ $category->average }}</td>
                            </tr>
                        @endforeach
                    </thead>
                    <tfoot>

                    </tfoot>
                </table>
            </div>





        </div><!--div clas row -->
        <br>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4>Remarks and Suggestion</h4>
                <p>{{ $category->remark }}</p>

            </div>
        </div> <!-- div class row -->

    </div> <!--div class container -->

    <br><br>

@endsection


