@extends('layouts.admin-layout')

@section('content')


{{-- <script type="text/javascript" src="{{asset('/js/moment.js')}}"></script> --}}

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
                <h3>FACULTY SCHEDULES</h3>
            </div>
            @php
                $lname = '';
                $fname = '';
                $mname = '';
                $name = '';

                if($faculty->mname != ''){
                    $lname = $faculty->lname;
                    $fname = $faculty->fname;
                    $mname = $faculty->mname;
                    $name = $fname . ' ' . substr($mname, -1) . '. ' . $lname;
                }else{
                    $lname = $faculty->lname;
                    $fname = $faculty->fname;
                    $name = $fname . ' ' . $lname;
                }
            @endphp

            <div class="row justify-content-center" style="border-bottom: 1px solid #05a805;">
                <h5>{{ $name }}</h5>
            </div>

               <br>

        <div class="row justify-content-center">

            <div class="col-md-12">

                <table id="schedules" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Schedule Code</th>
                            <th>Course Code</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Day</th>
                            <th>Room</th>
                        
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Schedule Code</th>
                            <th>Course Code</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Day</th>
                            <th>Room</th>
                          
                        </tr>
                    </tfoot>

                </table>
            </div>

        </div><!--div clas row -->



    </div>


@endsection


@section('extrascript')

<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#schedules').DataTable({

            processing : true,
            ajax : {
                url: '/data/ajax-schedules?fid='+{{ $faculty_id }},
                dataSrc: ''
            },
            columns: [
                { data : 'schedule_id', visible :true },
                { data : 'schedule_code' },
                { data : 'course.course_name' },
                { data : 'time_start' },
                { data : 'time_end' },
                { data : 'sched_day' },
                { data : 'room' },

        
            ],

            // columnDefs:[
            //     {
            //         targets:4, render:function(data){
            //             return moment(data).format('LT');
            //         }
            //     }
            // ]

        });

        $('#schedules tbody').on( 'click', '#btnRating', function () {
            var data = table.row( $(this).parents('tr') ).data();
            //window.location = '/cpanel-report-faculty/schedule/'+data['faculty_id'] + '/schedule/rate?sid='+ data['schedule_id'] + '&fid='+ data['faculty_id'];
            window.location = '/cpanel-report-faculty/schedule/'+ {{ $faculty_id }} + '/'+data['schedule_code'];

        });//end btnRating


    }); // end document ready


</script>

@endsection
