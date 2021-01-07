<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Print</title>

    <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/style.css") }}" />


    <style>
        .legend{
            list-style-type: circle;
        }
        .legend > li{
            border-right: 1px solid black;
        }
        .legend > li{
            display: inline-block;
            float: left;
            margin-bottom: 10px;
            padding: 10px;
            
        }

        @media print {
            .myDivToPrint {
                background-color: white;
                height: 100%;
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
                margin: 0;
                padding: 15px;
                font-size: 14px;
                line-height: 18px;
            }
}


    </style>

</head>


<body style="padding: 0;">

   

<div id="printarea" class="myDivToPrint">
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
    
                    </div>
                </div>
    
            </div>
        </div>
    
        <hr>
    
       
        <h4>RESULT</h4><br>
    
        {{-- <div class="row">
            <div class="col">
                
                <b>Legend</b> :
                    <ul class="legend">
                        <li>Outstanding</li>
                        <li>Very Satisfactory</li>
                        <li>Satisfactory</li>
                        <li>Unsatisfactory</li>
                        <li>Poor</li>
                    </ul>
            </div>
        </div> --}}
    
        <div class="row">
    
            
    
            <div class="col-md-4">
    
                @php
                    $total_avg=0;
                    $total = 0;
                    $count = 0;
                        foreach($result as $r){
    
                            $total = $total + $r->no_students;
                        }
                @endphp
    
    
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <h5>Teacher Information</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i>Name : {{$result[0]->lname }}, {{ $result[0]->fname }} {{$result[0]->mname}}</i> <b></b></li>
                        <li class="list-group-item">Institute :  {{$result[0]->institute}}</li>
                        <li class="list-group-item">No. of Students : {{ $total }}<b></b></li>
                    </ul>
                </div>
            </div>
    
            <div class="col">
                
                <table id="" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Courses</th>
                        <th>Assessment</th>
                    </tr>
    
                    @foreach($result as $r)
    
                        @php
                            $count++;
                            $total_avg = $total_avg + $r->avg_rating;
    
                        @endphp
    
                        <tr>
                            <td>{{ $r->course_name }} ({{ $r->schedule_code }})</td>
                            <td>{{ round($r->avg_rating,2) }}</td>
                        </tr>
                    @endforeach
    
                        @php
                            $final_avg = 0;
                            $final_avg = round($total_avg / $count,2);
    
                            $legend = \DB::table('legends')
                            ->where('start_value', '>=', $final_avg)
                            ->orderBy('start_value', 'desc')->first();
                        @endphp
                        <tr>
                            <td><b>Final Assessment</b></td>
                            <td><b>{{ $final[0]->avg_rating }} ({{ $final[0]->legend }})</b></td>
                        </tr>
                    </thead>
                </table>
    
            </div><!--div class md-6 closing tag-->
    
        </div><!--div class row -->
    
        <br>

        <div class="row">
            <div class="col">
                <div class="card">
                    <h5 class="card-header">Remarks/Suggestion</h5>
                    <div class="card-body">
                      <p class="card-text">{{ $final[0]->remarks }}</p>
                    </div>
                  </div>
            </div>
        </div><!--close row-->
        <br>
    
    </div> <!--div class container -->


</div><!-- end printarea-->


<!--BUTTON PRINT-->
<div class="container">
    <div class="row">
        <button class="btn btn-primary" onclick="printMe()">PRINT</button>
    </div>
   
</div>



    <script type="text/javascript">



        function printMe(){
            window.print();
        }

        
    </script>


</body>
</html>




