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
            /*.myDivToPrint {*/
            /*    background-color: white;*/
            /*    height: 100%;*/
            /*    width: 100%;*/
            /*    position: fixed;*/
            /*    top: 0;*/
            /*    left: 0;*/
            /*    margin: 0;*/
            /*    padding: 15px;*/
            /*    font-size: 14px;*/
            /*    line-height: 18px;*/
            /*}*/

            .myDivToPrint{
                margin: 0;
                color: #000;
                background-color: #fff;
                font-size: 14px;
                height: 100%;

            }
            .nprint{
                display: none;
            }
            header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
                display: none;
            }

        }

    </style>

</head>


<body style="padding: 0;">




<div id="printarea" class="myDivToPrint">
    <div class="container">

        <div class="row">

            <div style="width: 100%;" class="mt-4">

                <div class="d-flex justify-content-center">
                    <img class="" src="{{ asset('img/logo.png') }}" height="80">
                    <div class="mt-3">
                        <div class="d-flex justify-content-center">Gov. Alfonso D. Tan College</div>
                        <div class="d-flex justify-content-center">Maloro, Tangub City, Misamis Occidental</div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-5">
                    <div class="d-flex flex-column">
                        <h4 class="d-flex justify-content-center">Teacher Performance Evaluation Result</h4>
                        <h5 class="d-flex justify-content-center">{{$result[0]->ay_desc}}</h5>
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

                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <h5>Teacher Information</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i>Name : {{$result[0]->lname }}, {{ $result[0]->fname }} {{$result[0]->mname}}</i> <b></b></li>
                        <li class="list-group-item">Institute :  {{$result[0]->institute}}</li>
                        <li class="list-group-item">No. of Students : {{ $final[0]->rated }}/{{ $final[0]->raters }} ({{ round(($final[0]->rated/$final[0]->raters),4) * 100 }}%)<b></b></li>
                    </ul>
                </div>
            </div>

            <div class="col">

                <table id="" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Courses</th>
                        <th>No of Rater(s)</th>
                        <th>Assessment</th>
                    </tr>

                    @foreach($result as $r)

                        <tr>
                            <td>{{ $r->course_name }} ({{ $r->schedule_code }})</td>
                            <td>{{ $r->no_of_raters }}/{{ $r->no_students }} ({{ round($r->no_of_raters/$r->no_students,4) * 100 }}%)</td>
                            <td>{{ round($r->avg_rating,2) }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td><b>Final Assessment</b></td>
                            <td colspan="2" style="text-align: right;"><b>{{ $final[0]->avg_rating }} ({{ $final[0]->legend }})</b></td>
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

{{--                      <p class="card-text">{{ $final[0]->remarks }}</p>--}}

                        <table class="table">

                        @php
                            for($r=0; $r < sizeof($comments); $r+=2){
                                echo '<tr><td>' .$comments[$r]->remark. '</td>';

                                if($r+1 < sizeof($comments)){
                                     echo '<td>' .$comments[$r+1]->remark. '</td>';
                                }

                                echo '</tr>';
                            }


                        @endphp
                        </table>


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
        <button class="btn btn-primary nprint" onclick="printMe()">PRINT</button>
    </div>

</div>



    <script type="text/javascript">



        function printMe(){
            window.print();
        }


    </script>


</body>
</html>




