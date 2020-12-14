@extends('layouts.admin-layout')

@section('content')


    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>SAVED!</strong> {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('deleted'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>DELETED!</strong> {{session('deleted')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('updated'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>UPDATED!</strong> {{session('updated')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="row justify-content-center" style="border-bottom: 1px solid #05a805;">
            <h3>SCHEDULE UPLOADER</h3>
        </div>

        <br>
        <div class="row justify-content-center">


            <script src="{{ asset('/js/jszip.js') }}"></script>
            <script src="{{ asset('/js/xlsx.js') }}"></script>
            <script>
                var ExcelToJSON = function() {

                    this.parseExcel = function(file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;
                            var workbook = XLSX.read(data, {
                                type: 'binary'
                            });
                            workbook.SheetNames.forEach(function(sheetName) {
                                // Here is your object
                                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                                var json_object = JSON.stringify(XL_row_object);
                                console.log(JSON.parse(json_object));
                                jQuery( '#xlx_json' ).val( json_object );
                            })
                        };

                        reader.onerror = function(ex) {
                            console.log(ex);
                        };

                        reader.readAsBinaryString(file);
                    };
                };

                function handleFileSelect(evt) {

                    var files = evt.target.files; // FileList object
                    var xl2json = new ExcelToJSON();
                    xl2json.parseExcel(files[0]);
                }



            </script>


            <form enctype="multipart/form-data" method="post" action="/quiz/question/uploader/39/store">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Upload</span>
                    </div>
                    <div class="custom-file">
                        {{-- <input id="upload" type="file" class="form-control"  name="files[]"> --}}
                        <input type="file" class="custom-file-input" id="upload" name="files[]">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>


                @csrf


                <div class="form-group">

                </div>

                <textarea readonly class="form-control" name="user_json" rows=20 cols=120 id="xlx_json"></textarea>


                <div class="row mt-2" style="float: right;">
                    <button class="btn btn-primary">Upload</button>
                </div>

                <div class="clearfix"></div>

                <script>
                    document.getElementById('upload').addEventListener('change', handleFileSelect, false);
                </script>

            </form>

        </div> <!--close row -->
    </div><!-- close container -->

@endsection

@section('extrascript')

    <script type="text/javascript">

        $(document).ready(function() {



        }); // end document ready


    </script>

@endsection
