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

		<!--MODAL-->
		{{-- <div class="modal fade" id="modal-criteria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">

		      <div class="modal-header">
		        <h5 class="modal-title" id="">Update Criteria</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>

		      <div class="modal-body">
		        
		        <form>

		        	<div class="row">
		        		<div class="col-md-6">
		        			<div class="form-group">
		        			  <label for="criterion_id" class="col-form-label">Criterion ID:</label>
		        			  <input type="text" class="form-control" id="criterion_id" name="criterion_id" readonly="readonly">
		        			
		        			</div>
		        		</div>
		        		
		        		<div class="col-md-6">
		        			<div class="form-group">
		        			  <label for="order_no" class="col-form-label">Order No:</label>
		        			  <input type="number" class="form-control" id="order_no" name="order_no" required="required" autocomplete="off">
		        				
		        			</div>
		        		</div>
		        	</div><!--close row-->

					
					<div class="form-group">
					  <label for="ay_id" class="col-form-label">A.Y. Code</label>
					  <select name="ay_id" id="ay_id" class="form-control">
					  	@foreach($ay as $ay)
					  		<option value="{{ $ay->ay_id }}">{{$ay->ay_code}} ({{$ay->ay_desc}})</option>
					  	@endforeach
					  	
					  </select>
					</div>
			     

		          <div class="form-group">
		            <label for="criterion" class="col-form-label">Criterion:</label>
		            <textarea class="form-control" id="criterion" name="criterion" required="required"></textarea>
		          </div>

		          <div class="form-group">
		           <label for="category_id" class="col-form-label">Category:</label>
		           <select name="category_id" id="category_id" class="form-control">
		           	@foreach($categories as $cat)
		           		<option value="{{ $cat->category_id }}">{{$cat->category}}</option>
		           	@endforeach
		           	
		           </select>
		          </div>
		          

		        </form>

		      </div>

		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary" id="btnUpdate">Update Criteria</button>
		      </div>

		    </div>
		  </div>
		</div> --}}
		<!--CLOSE MODAL-->
		
		<div class="row justify-content-center" style="border-bottom: 1px solid #05a805;">
			<h3>CRITERIA</h3>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-10">

				<a href="/cpanel-criteria/create" class="btn btn-primary" style="margin-bottom: 20px; margin-top: 20px;">New Criterion</a>

				<table id="criteria" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Criterion</th>
							<th>Category</th>
							<th>Order No</th>
							<th style="display: none;">category_id</th>
							<th style="display: none;">ay_id</th>
							<th style="display: none;">ay_code</th>
							<th>Action</th>
						</tr>
					</thead>
				
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Criterion</th>
							<th>Category</th>
							<th>Order No</th>
							<th style="display: none;">category_id</th>
							<th style="display: none;">ay_id</th>
							<th style="display: none;">ay_code</th>
							<th>Action</th>
						</tr>
					</tfoot>

				</table>

				<a href="/cpanel-criteria/create" class="btn btn-primary" style="margin-top: 20px;">New Criterion</a>
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

		    var table = $('#criteria').DataTable({

				processing : true,
				ajax : {
					url: '/ajax-criteria',
					dataSrc: ''
				},
				columns: [
					{ data : 'criterion_id' },
					{ data : 'criterion' },
					{ data : 'category' },
					{ data : 'order_no' },
					{ data: 'category_id', visible : false, searchable : false },
					{ data: 'ay_id', visible : false, searchable : false },
					{ data: 'ay_code', visible : false, searchable : false },
					{

						"defaultContent": '<button class="btn btn-edit" id="edit"></button> &nbsp; <button class="btn btn-delete" id="delete"></button>'
						
					}
				],


			});



			$('#criteria tbody').on( 'click', '#edit', function () {
				var data = table.row( $(this).parents('tr') ).data();
				
				 var id = data['criterion_id'];
				window.location = '/cpanel-criteria/'+id+'/edit' ;
				
			});//criteria click edit
			

			$('#criteria tbody').on( 'click', '#delete', function () {
				var data = table.row( $(this).parents('tr') ).data();

				var token = $("meta[name=csrf-token]").attr('content');
				var method = $("input[name=_method]").val();
			
				var id = data['criterion_id'];
				var criterion = data['criterion'];
			
				$.confirm({
				    title: "DELETE CRITERION?",
				    content: criterion,
				    autoClose: 'CANCEL|8000',
				    buttons:{
				    	deleteUser:{
				    		text : 'DELETE',
				    		action : function(){

				    			$.post('/cpanel-criteria/'+id,
				    			{
				    				_token : token,
				    				_method : method
				    			},
				    			
				    			function(data, status){
				    				
				    				//$.alert(data + ' -> ' +status);
				    				if(status=="success"){
				    					$('#criteria').DataTable().ajax.reload();
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

				
		

			});//end criteria tr click delete

		}); // end document ready


	</script>

@endsection
