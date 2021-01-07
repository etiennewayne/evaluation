<!DOCTYPE html>
<html>
<head>

  <title>Print</title>

  <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css") }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset("/css/style.css") }}" />

</head>


<body onload="printMe()" style="padding: 0;">

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


          <div class="row">

              <div class="col-md-4">


                      <div class="card" style="width: 18rem;">
                        <div class="card-header">
                          <h5>Teacher Information</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><i>Name :</i> <b></b></li>
                          <li class="list-group-item">Institute :  </li>
                          <li class="list-group-item"># of Student : <b></b></li>
                          <li class="list-group-item">Employment Status : </li>
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




