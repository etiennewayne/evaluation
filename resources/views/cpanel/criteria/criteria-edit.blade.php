@extends('layouts.admin-layout')

@section('content')



		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('Criterion Information') }}</div>

					<div class="card-body">
					
					<form method="POST" action="/cpanel-criteria/{{$criterion->criterion_id}}">
					
						@csrf
						@method('PUT')	

							<div class="form-group row">
								<label for="ay_id" class="col-md-4 col-form-label text-md-right">{{ __('Academic Year') }}</label>
								<div class="col-md-6">
									<select class="form-control" name="ay_id" id="ay_id">
										@foreach($ay as $ay)
											@if($ay->ay_id == $criterion->ay_id)
												<option selected value="{{ $ay->ay_id }}">{{ $ay->ay_desc }} ({{ $ay->ay_code }})</option>
											@else
												<option value="{{ $ay->ay_id }}">{{ $ay->ay_desc }} ({{ $ay->ay_code }})</option>
											@endif
											
										@endforeach
									</select>
								</div>
							</div> 

							<div class="form-group row">
								<label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

								<div class="col-md-6">
									<select class="form-control" name="category_id">
										@foreach($categories as $category)
										
											@if($category->category_id == $criterion->category_id)
												<option selected value="{{ $category->category_id }}">{{ $category->category }}</option>
											@else
												<option value="{{ $category->category_id }}">{{ $category->category }}</option>
											@endif
										@endforeach

										
	
									</select>
								</div>
							</div>


							<div class="form-group row">
								<label for="order_no" class="col-md-4 col-form-label text-md-right">{{ __('Order No.') }}</label>

								<div class="col-md-6">
									<input id="order_no" type="number" class="form-control @error('order_no') is-invalid @enderror" name="order_no" value="{{ $criterion->order_no }}" required autocomplete="off">

									@error('order_no')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>


							<div class="form-group row">
								<label for="criterion" class="col-md-4 col-form-label text-md-right">{{ __('Criterion') }}</label>

								<div class="col-md-6">
									<textarea name="criterion" id="criterion" rows="3" class="form-control @error('criterion') is-invalid @enderror" required>{{ $criterion->criterion }}</textarea>
									
									@error('criterion')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

			
							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary">
										{{ __('Update Criterion') }}
									</button>
								</div>
							</div>
						</form>
					</div><!-- close card-body -->
				</div><!--close card-->
				
			</div> <!--close col-8 -->
			
		</div> <!-- close row -->



@endsection