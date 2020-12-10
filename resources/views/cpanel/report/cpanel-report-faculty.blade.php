@extends('layouts.admin-layout')

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


        {{-- <div class="row justify-content-center">

            <img src="{{ asset('img/logo.png') }}" height="100">

            <div class="justify-content-center">
                <p style="margin: 0; margin-top: 20px;" class="text-center">RATING SHEET IN TEACHING PERFORMANCE</p>
                <p style=";" class="text-center">{{ $ay->ay_desc }}</p>
            </div>

        </div> --}}

       <div class="row justify-content-center" style="border-bottom: 1px solid #05a805;">
		<h3>FACULTY LIST</h3>
       </div>
       <br>
	   
        <div class="row justify-content-center">

            <div class="col-md-12">
                
                <table id="faculty" class="table table-striped table-bordered" style="width:100%">
                	<thead>
                		<tr>
                			<th>ID</th>
                			<th>Lastname</th>
                			<th>Firstname</th>
                			<th>Middlename</th>
                			<th>Action</th>
                		</tr>
                	</thead>
                	
                	<tfoot>
                		<tr>
                			<th>ID</th>
                			<th>Lastname</th>
                			<th>Firstname</th>
                			<th>Middlename</th>
                			<th>Action</th>
                		</tr>
                	</tfoot>

                </table>
            </div>
            
        </div><!--div clas row -->
        

    </div> <!--div class container -->
    
    <br><br>

@endsection


@section('extrascript')

	<script type="text/javascript">
		$(document).ready(function() {

		    var table = $('#faculty').DataTable({

				processing : true,
				ajax : {
					url: '/data/ajax-faculties',
					dataSrc: ''
				},
				columns: [
					{ data : 'faculty_id' },			
					{ data : 'lname' },
					{ data : 'fname' },
					{ data : 'mname' },
					{

						"defaultContent": '<button class="btn btn-primary" id="btnSchedule">Schedule</button> &nbsp; <button class="btn btn-primary" id="btnTotalRating">Total Rating</button>'
						{{--'<form style="display: inline;" action="cpanel-users/'+ 0 +' method="post">--}}
						{{--@csrf--}}
						{{--@method("DELETE")--}}
							{{--<input type="submit" class="btn-link" name="submit" value="Delete">'--}}
					}
				]

			});

			$('#faculty tbody').on( 'click', '#btnTotalRating', function () {
				var data = table.row( $(this).parents('tr') ).data();
				window.location = '/cpanel-report/'+data['faculty_id'];
				
			});//end btnTotalRating

            $('#faculty tbody').on( 'click', '#btnSchedule', function () {
                var data = table.row( $(this).parents('tr') ).data();
                window.location = '/cpanel-report/'+data['faculty_id'] + '/schedule';
                
            });//end btnTotalRating


		}); // end document ready


	</script>
@endsection