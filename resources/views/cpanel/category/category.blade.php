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
			<h3>CATEGORIES</h3>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-10">

				<a href="/cpanel-category/create" class="btn btn-primary" style="margin-bottom: 20px; margin-top: 20px;">New Category</a>

				<table id="categories" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Category</th>
							<th>Order No</th>
							<th style="display: none;">ay_id</th>
							<th>A.Y. Code</th>
							<th>Action</th>
						</tr>
					</thead>
				
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Category</th>
							<th>Order No</th>
							<th style="display: none;">ay_id</th>
							<th>A.Y. Code</th>
							<th>Action</th>
						</tr>
					</tfoot>

				</table>

				<a href="/cpanel-category/create" class="btn btn-primary" style="margin-top: 20px;">New Category</a>
				<a href="/cpanel-category/copy-previous" class="btn btn-primary" style="margin-top: 20px;">Copy Previous</a>
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

		    var table = $('#categories').DataTable({

				processing : true,
				ajax : {
					url: '/ajax-category',
					dataSrc: ''
				},
				columns: [
					{ data : 'category_id' },
					{ data : 'category' },
					{ data : 'order_no' },
					{ data: 'ay_id', visible : false, searchable : false },
					{ data: 'ay_code' },
					{

						"defaultContent": '<button class="btn btn-edit" id="edit"></button> &nbsp; <button class="btn btn-delete" id="delete"></button>'
						
					}
				],


			});



			$('#categories tbody').on( 'click', '#edit', function () {
				var data = table.row( $(this).parents('tr') ).data();
				
				var id = data['category_id'];
				window.location = '/cpanel-category/'+id+'/edit' ;
				
			});//criteria click edit
			

			$('#categories tbody').on( 'click', '#delete', function () {
				var data = table.row( $(this).parents('tr') ).data();

				var token = $("meta[name=csrf-token]").attr('content');
				var method = $("input[name=_method]").val();
			
				var id = data['category_id'];
				var category = data['category'];
			
				$.confirm({
				    title: "DELETE CATEGORY?",
				    content: category,
				    autoClose: 'CANCEL|8000',
				    buttons:{
				    	deleteUser:{
				    		text : 'DELETE',
				    		action : function(){

				    			$.post('/cpanel-category/'+id,
				    			{
				    				_token : token,
				    				_method : method
				    			},
				    			
				    			function(data, status){
				    				
				    				//$.alert(data + ' -> ' +status);
				    				if(status=="success"){
				    					$('#categories').DataTable().ajax.reload();
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
