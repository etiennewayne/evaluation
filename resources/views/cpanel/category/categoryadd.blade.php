@extends('layouts.admin-layout')

@section('content')



		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('Category Information') }}</div>

					<div class="card-body">
					
						<form method="POST" action="/cpanel-category">
							@csrf

							<div class="form-group row">
								<label for="ay_id" class="col-md-4 col-form-label text-md-right">{{ __('Academic Year') }}</label>
								<div class="col-md-6">
									<select class="form-control" name="ay_id" id="ay_id">
										@foreach($ay as $ay)
											<option value="{{ $ay->ay_id }}">{{ $ay->ay_desc }} ({{ $ay->ay_code }})</option>
										@endforeach
									</select>
								</div>
							</div> 

							<div class="form-group row">
								<label for="criterion" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

								<div class="col-md-6">
									<input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" required>
									
									@error('criterion')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							
							<div class="form-group row">
								<label for="order_no" class="col-md-4 col-form-label text-md-right">{{ __('Order No.') }}</label>

								<div class="col-md-6">
									<input id="order_no" type="number" class="form-control @error('order_no') is-invalid @enderror" name="order_no" value="{{ old('order_no') }}" required autocomplete="off">

									@error('order_no')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>


							

			
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary">
										{{ __('Save Category') }}
									</button>
								</div>
							</div>
						</form>
					</div><!-- close card-body -->
				</div><!--close card-->
				
			</div> <!--close col-8 -->
			
		</div> <!-- close row -->



@endsection