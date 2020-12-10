<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/style.css") }}" />
    
    <title>Print Per Schedule</title>
</head>
<body onload="printMe()" style="padding: 0px;">

    <div class="container">
    
        <div class="row justify-content-center">
            <div style="display: flex;">
                <div>
                    <img src="{{ asset('img/logo.png') }}" height="80">
                </div>
                
                <div class="print-letterhead-col2">
                  <div>
                    <h4>Teacher Performance Evaluation Result</h4>
                  </div>
                  <div style="text-align: center;">
                    {{ $ay->ay_desc }}
                  </div>
                </div>
            
            </div>
        </div>
        
        

        <hr>
   
               @php
                        $name = '';
                        $institute = '';
                        $raters = 0;
                        $status = '';
                        $total_raters = 0;
                        $avg = 0.00;
            
                    foreach($data as $info){
            
                        
                            $name = $info->lname . ', ' . $info->fname . ' ' . $info->mname;
                            //$name = $info->lname;
                            $institute = $info->institute_code;
                            $raters = $info->students_count;
                            $status = $info->status;
                            $total_raters = $info->total_raters;
            
            
                            
                    }
                    
                    if($data != null){
                      $avg = round( (($raters/$total_raters) * 100), 2);
                    }
            
                    
            
               @endphp


        <div class="row">

            <div class="col-md-4">
               
                    <div class="card" style="width: 18rem;">
                      <div class="card-header">
                        <h5>Teacher Information</h5>
                      </div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i>Name :</i> <b>{{ $name }}</b></li>
                        <li class="list-group-item">Institute : {{ $institute }} </li>
                        <li class="list-group-item"># of Student : {{ $raters }}/{{ $total_raters }} <b>({{$avg}}%)</b></li>
                        <li class="list-group-item">Employment Status : {{ $status }}</li>
                      </ul>
                    </div>
            </div>

            <div class="col-md-8">
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
                  {{  $sum = 0 }}
                        @foreach($data as $cat)
                            <tr>
                                <td>{{ $cat->category }}</td>
                                <td>{{ $cat->assessment }}</td>
                                <td>{{ $cat->legend }}</td>
                               
                            </tr>


                        @endforeach
                        <tr>
                          <td><b>AVERAGE : </b></td>
                          @php
                            if($data != null){
                              echo '<td><b>'. $data[0]->final_assessment .'</b></td>
                                    <td><b>'. $data[0]->final_legend .'</b></td>';
                            }else{
                              echo '<td><b>0.00</b></td>
                                    <td><b>NONE</b></td>';
                            }

                          @endphp
                        </tr>
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

                    @foreach($remarks_suggestion as $r)
                       <tr>
                            <td> <b>{{ $r->category }}</b>
                                @foreach($r->schedules as $sched)
                                     <ul>
                                         @foreach($sched->remarks as $remark)
                                             @if($remark->user_remark != null)
                                                <li style="display:inline-block;"> **{{ $remark->user_remark }} &emsp; </li>
                                             @endif
                                         @endforeach
                                     </ul>
                                @endforeach
                            </td>
                       </tr>
                    @endforeach


                </table>
            </div>
        </div><!--close row-->
        
    </div> <!--div class container -->
    

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

    function printMe(){
        window.print();
    }

	</script>
    
</body>
</html>


    
