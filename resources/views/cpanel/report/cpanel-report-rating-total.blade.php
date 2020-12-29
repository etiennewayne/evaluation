@extends('layouts.admin-layout')

@section('content')




    <div class="container">



        <div class="row justify-content-center">
            <h4>Teacher Performance Evaluation Result</h4>
        </div>
        <div class="row justify-content-center">
                {{ $ay->ay_desc}}
        </div>

        <a href="{{$faculty->faculty_code}}/print/print-report-rating-total" class="btn btn-outline-primary">Print</a>
        <hr>



        <div class="row">

            <div class="col-md-4">


                    <div class="card" style="width: 18rem;">
                      <div class="card-header">
                        <h5>Teacher Information</h5>
                      </div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i>Name :</i> <b>{{$faculty->lname}}, {{$faculty->fname}} {{$faculty->mname}}</b></li>
                        <li class="list-group-item">Institute : {{ $faculty->institute  }} </li>
                        <li class="list-group-item"># of Student :  <b></b></li>
                      </ul>
                    </div>
            </div>

            <div class="col-md-6">
                <h4>Result</h4>
                <b>Legend</b> : O-Outstanding VS-Very Satisfactory<br>
                S-Satisfactory U-Unsatisfactory P-Poor
                <table id="" class="table table-striped table-bordered">
                	<thead>
                		<tr>
                			<th>Areas</th>
                			<th colspan="2">Assessment</th>

                		</tr>
                	</thead>
                </table>
            </div>

        </div><!--div clas row -->


        <div class="row">

            <div class="col-md-12">
                <table id="" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Remark(s)</th>
                        </tr>
                    </thead>



                </table>
            </div>



        </div><!--close row-->





    </div> <!--div class container -->



@endsection


@section('extrascript')

	<script type="text/javascript">
		$(document).ready(function() {

		    var table = $('#faculty').DataTable({

				processing : true,
				ajax : {
					url: 'data/ajax-faculties',
					dataSrc: ''
				},
				columns: [
					{ data : 'faculty_id' },
					{ data : 'lname' },
					{ data : 'fname' },
					{ data : 'mname' },
					{

						"defaultContent": '<button class="btn btn-primary">Rating</button>'
						{{--'<form style="display: inline;" action="cpanel-users/'+ 0 +' method="post">--}}
						{{--@csrf--}}
						{{--@method("DELETE")--}}
							{{--<input type="submit" class="btn-link" name="submit" value="Delete">'--}}
					}
				]

			});

			$('#faculty tbody').on( 'click', 'button', function () {
				var data = table.row( $(this).parents('tr') ).data();
				window.location = '/cpanel-report/'+data['faculty_id'];
				//console.log(data['user_id']);
				//alert( data[0] +"'s salary is: "+ data[1] );
			});

		}); // end document ready


	</script>
@endsection
