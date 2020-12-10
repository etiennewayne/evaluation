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
			<h3>ACADEMIC YEARS</h3>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-10">

				<a href="/cpanel-academicyear/create" class="btn btn-primary" style="margin-bottom: 20px; margin-top: 20px;">New A.Y.</a>

				<table id="academicyear" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>A.Y. Code</th>
							<th>A.Y. Description</th>
                            <th>Active</th>
							<th>Action</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>ID</th>
							<th>A.Y. Code</th>
							<th>A.Y. Description</th>
                            <th>Active</th>
							<th>Action</th>
						</tr>
					</tfoot>

				</table>

				<a href="/cpanel-academicyear/create" class="btn btn-primary" style="margin-top: 20px;">New A.Y.</a>
			</div>

			{{-- @csrf --}}
			@method('DELETE')

		</div> <!--close row -->

		{{-- <form id="delete-form" style="display: inline;" action="/cpanel-criteria/22" method="post">
					@csrf
					@method("DELETE")
					<button class="btn btn-primary" type="submit">test</button>
		</form>
							 --}}
    </div><!-- close container -->

@endsection

@section('extrascript')

	<script type="text/javascript">

		$(document).ready(function() {

		    var table = $('#academicyear').DataTable({

				processing : true,
				ajax : {
					url: '/ajax-academicyear',
					dataSrc: ''
				},
				columns: [
					{ data : 'ay_id' },
					{ data : 'ay_code' },
					{ data : 'ay_desc' },
					{ data : 'active' },
					{

						"defaultContent": '<button class="btn btn-edit" id="edit"></button> &nbsp; <button class="btn btn-delete" id="delete"></button> &nbsp; <button class="btn btn-active" id="active"></button>'

					}
				],


			});



			$('#academicyear tbody').on( 'click', '#edit', function () {
				var data = table.row( $(this).parents('tr') ).data();

				var id = data['ay_id'];
				window.location = '/cpanel-academicyear/'+id+'/edit' ;

			});//academicyear click edit


            $('#academicyear tbody').on( 'click', '#active', function () {
				var data = table.row( $(this).parents('tr') ).data();
				var id = data['ay_id'];
                var bodymsg = data['ay_code'] + ', ' + data['ay_desc'];

                var token = $("meta[name=csrf-token]").attr('content');
				//var method = $("input[name=_method]").val();


                $.confirm({
				    title: "SET THIS AS ACTIVE?",
				    content: bodymsg,
				    autoClose: 'CANCEL|8000',
				    buttons:{
				    	deleteUser:{
				    		text : 'ACTIVE',
				    		action : function(){

				    			$.post('/cpanel-academicyear/set-active',
				    			{
				    				_token : token,
                                    ay_id : id
				    				//_method : method
				    			},

				    			function(data, status){

				    				//$.alert(data + ' -> ' +status);
				    				if(status=="success"){


				    					$('#academicyear').DataTable().ajax.reload();
				    					//$.alert('Deleted successfully');
				    				}else{
				    					$.alert('An error occured. ERROR : ' +status);
				    				}

				    			});
				    		}
				    	},
				    	CANCEL: function() {

				    		$.alert('Setting active canceled.');
				    	}
				    }//button end
				});//end alert confirm


			});//academicyear click active


			$('#academicyear tbody').on( 'click', '#delete', function () {
				var data = table.row( $(this).parents('tr') ).data();

				var token = $("meta[name=csrf-token]").attr('content');
				var method = $("input[name=_method]").val();

				var id = data['ay_id'];
				var bodymsg = data['ay_desc'];

				$.confirm({
				    title: "DELETE CRITERION?",
				    content: bodymsg,
				    autoClose: 'CANCEL|8000',
				    buttons:{
				    	deleteUser:{
				    		text : 'DELETE',
				    		action : function(){

				    			$.post('/cpanel-academicyear/'+id,
				    			{
				    				_token : token,
				    				_method : method
				    			},

				    			function(data, status){

				    				//$.alert(data + ' -> ' +status);
				    				if(status=="success"){
				    					$('#academicyear').DataTable().ajax.reload();
				    					$.alert('Deleted successfully');
				    				}else{
				    					$.alert('An error occured. ERROR : ' +status);
				    				}

				    			});
				    		}
				    	},
				    	CANCEL: function() {

				    		$.alert('Deletion canceled.');
				    	}
				    }//button end
				});//end alert confirm




			});//end academicyear tr click delete

		}); // end document ready


	</script>

@endsection
