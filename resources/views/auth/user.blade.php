@extends('layouts.admin-layout')

@section('content')



<div class="container">

	<!-- <h1>Users</h1> -->

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
        <h3>USERS</h3>
    </div>
       <br>

	<div class="row">
    	<a href="/cpanel-users/create" class="btn btn-primary">Add Account</a>
    </div>

	<br>

    <div class="row">

		<div class="col-md-12">
			<table id="users" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>User ID</th>
						<th>Username</th>
						<th>Lastname</th>
						<th>Firstname</th>
						<th>Middlename</th>
						<th>Sex</th>
						<th>Action</th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th>User ID</th>
						<th>Username</th>
						<th>Lastname</th>
						<th>Firstname</th>
						<th>Middlename</th>
						<th>Sex</th>
						<th>Action</th>
					</tr>
				</tfoot>

			</table>

			@method('DELETE')

		</div> <!--close col md 10-->
		
		
    </div><!-- close row-->

    

  	

</div><!-- close container-->


@endsection

@section('extrascript')

	<script type="text/javascript">
		$(document).ready(function() {

		    var table = $('#users').DataTable({

				processing : true,
				ajax : {
					url: '/data/ajax-users',
					dataSrc: ''
				},
				columns: [
					{ data : 'user_id' },
					{ data : 'username' },
					{ data : 'lname' },
					{ data : 'fname' },
					{ data : 'mname' },
					{ data : 'sex' },
					{

						"defaultContent": '<button class="btn btn-edit" id="edit"></button> &nbsp; <button class="btn btn-delete" id="delete"></button>'
					}
				]

			});

			$('#users tbody').on( 'click', '#edit', function () {
				var data = table.row( $(this).parents('tr') ).data();
				window.location = '/cpanel-users/' + data['user_id'] + "/edit";
				
			});

			$('#users tbody').on( 'click', '#delete', function () {
				var data = table.row( $(this).parents('tr') ).data();

				var lname = data['lname'];

				var token = $("meta[name=csrf-token]").attr('content');
				var method = $("input[name=_method]").val();
				//method = '_method';
				var id = data['user_id'];

				$.confirm({
				    title: "DELETE USER?",
				    content: lname,
				    type: 'red',
				    autoClose: 'CANCEL|8000',
				    buttons:{
				    	deleteUser:{
				    		text : 'DELETE',
				    		action : function(){

				    			$.post('/cpanel-users/'+id,
				    			{
				    				_token : token,
				    				_method : method
				    			},
				    			function(data, status){
				    				
				    				//$.alert(data + ' -> ' +status);
				    				if(status=="success"){
				    					$('#users').DataTable().ajax.reload();
				    					$.alert({
				    						title: "DELETED SUCCESSFULLY!",
				    						content : data,
				    						type: 'green'
				    					});
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

			});// end delete method




		}); // end document ready


	</script>

@endsection

