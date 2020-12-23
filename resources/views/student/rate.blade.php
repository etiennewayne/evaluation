@extends('layouts.student-layout')

@section('content')

<style>
    .errormsg-rate{
        display: none;
       font-weight: bold;
       color:red;
    }

</style>

<link rel="stylesheet" type="text/css" href="{{ asset("/css/jquery-confirm.css") }}" />

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


            <div class="row">

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <b>SCHEDULE INFORMATION</b>
                    </div>

                    <div class="card-body">
						<table>
							<tr>
								<td style="width:150px;"><b>Schedule Code</b> :</td>
{{--								<td>{{ $schedule }}</td>--}}
							</tr>
							<tr>
								<td><b>Course</b> :</td>
								{{-- <td>{{ $schedule->course->course_code }} {{ $schedule->course->course }}</td> --}}
							</tr>
							{{-- <tr>
								<td><b>Schedule</b> :</td>
								<td>{{ \Carbon\Carbon::createFromFormat('H:i:s',$schedule->time_start)->format('h:i A')  }} -  {{ \Carbon\Carbon::createFromFormat('H:i:s',$schedule->time_end)->format('h:i A')  }} {{ $schedule->sched_day}} {{$schedule->course->course_class }}</td>
							</tr>
							<tr>
								<td><b>Instructor</b> :</td>
								<td>{{ $schedule->faculty->lname }}, {{ $schedule->faculty->fname }} {{ $schedule->faculty->mname[0] }}</td>
							</tr> --}}
						</table>
                    </div>

                  </div>
                </div><!--close md-6-->

                <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <b>LEGEND</b>
                      </div>
                      <div class="card-body">
                        {{-- <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}

                        <div class="container">
                          <div class="row">
                            <div class="col-md-6">
                                5 - Strongly Agree
                            </div>
                            <div class="col-md-6">
                                4 - Agree
                            </div>

                          </div>

                          <div class="row">
                              <div class="col-md-6">
                                  3 - Undecided
                              </div>
                              <div class="col-md-6">
                                  2 - Disagree
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-6">
                                  1 - Strongly Disagree
                              </div>
                              {{-- <div class="col-md-6">
                                  2 - Unsatisfactory
                              </div> --}}
                          </div>
                        </div>


                      </div><!--card body-->
                    </div><!--card-->
                </div>

            </div><!--close row-->
        <br>


        <form id="form-submit" method="post" action="/studyload/save">
        <div class="row justify-content-center">

            <input type="hidden" name="schedule_code" value="" />
            @csrf

            <table class="table mytable">

                    <th>CATEGORIES</th>
                    <th colspan="6">RATINGS</th>

                    @foreach($categories as $cat)
                        <tr>
                            <td colspan="100%" style="border-bottom: 1px solid black; border-top: 1px solid black;"><b>{{ $cat->category  }} </b></td>
                        </tr>
                       
                        @foreach($cat->criteria as $crit)

                            <tr id="row{{ $crit->criterion_id }}">
                                <td>&emsp; {{ $crit->criterion }}</td>
                                <td>

                                  @for($r=5;$r>=1;$r--)
                                      <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input"  name="rate[{{$crit->criterion_id}}]" id="rate[{{$crit->criterion_id}}][{{$r}}]" value="{{$r}}">
                                        <label class="custom-control-label" for="rate[{{$crit->criterion_id}}][{{$r}}]">{{$r}}</label>
                                      </div>
                                  @endfor
                                  <p class="errormsg-rate" id="errormsg{{ $crit->criterion_id }}"><i>Please rate this criterion.</i></p>
                                </td>

                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="100%"> &emsp; <i>Remarks/Suggestions :</i> <textarea rows="3" class="form-control" name="comment[{{ $cat->category_id }}][remark]"> </textarea>

                            </td>

                        </tr>
                    @endforeach

                </table>

        </div><!--div clas row -->

        {{-- <button id="btn-submit" class="btn btn-primary auto-width">SUBMIT</button> --}}
        </form>

        <button id="submit-rate" class="btn btn-primary auto-width">SUBMIT RATINGS</button>

    </div> <!--div class container -->

    <script type="text/javascript" src="{{asset('/js/jquery-confirm.js/')}}"></script>


<script type="text/javascript">
    var ctr = 0;

    btnSubmit = document.getElementById('submit-rate');
    form_submit = document.getElementById('form-submit');

    //var rate1 = document.getElementsByName('rate[1]');
    var radioValue = 0;

   @foreach($criteria as $criterion)
        var row{{ $criterion->criterion_id }} = document.getElementById('row{{ $criterion->criterion_id }}');
        var rate{{ $criterion->criterion_id }} = document.getElementsByName('rate[{{ $criterion->criterion_id }}]');
        var errormsg{{ $criterion->criterion_id }} = document.getElementById('errormsg{{ $criterion->criterion_id }}');
        var radioValue{{ $criterion->criterion_id }} = 0;


   @endforeach

    btnSubmit.onclick = function(){

        @foreach($criteria as $criterion)
            for(var i = 0; i < rate1.length; i++){
                if(rate{{ $criterion->criterion_id }}[i].checked){
                    radioValue{{ $criterion->criterion_id }} = rate{{ $criterion->criterion_id }}[i].value;
                    break;
                }
            }

            if(radioValue{{ $criterion->criterion_id }} < 1){
                row{{ $criterion->criterion_id }}.style.backgroundColor = 'pink';
                errormsg{{ $criterion->criterion_id }}.style.display='block';
                row{{ $criterion->criterion_id }}.scrollIntoView({ behavior: 'smooth', block: 'center'});

                return;
            }else{
                row{{ $criterion->criterion_id }}.style.backgroundColor = '';
                errormsg{{ $criterion->criterion_id }}.style.display='none';
            }

        @endforeach

        $.confirm({
            theme: 'supervan',
            title: "SUBMIT?",
            content: 'Are you sure you want to submit this rating? This action cannot be undone.',
            buttons:{
              confirm:{
                text : 'SUBMIT',
                action : function(){
                  form_submit.submit();
                }
              },
              cancel: {
                text : 'CANCEL',
                action: function() {

                }
              }
            }//button end
        });//end alert confirm
    }; //button submit jvscript

</script>

@endsection


