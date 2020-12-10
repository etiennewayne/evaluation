@extends('layouts.admin-layout')

@section('content')



		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('Academic Year Information') }}</div>

					<div class="card-body">

						<form method="POST" action="/cpanel-academicyear">

                            @csrf


                            <div class="form-group row">
								<label for="ay_code" class="col-md-4 col-form-label text-md-right">{{ __('A.Y. Code') }}</label>
								<div class="col-md-6">
									<input id="ay_code" type="text" class="form-control @error('ay_code') is-invalid @enderror" name="ay_code" value="{{ old('ay_code') }}" required autocomplete="off">

									@error('ay_code')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
                            </div>

                            <div class="form-group row">
								<label for="ay_desc" class="col-md-4 col-form-label text-md-right">{{ __('A.Y. Description') }}</label>
								<div class="col-md-6">
									<input id="ay_desc" type="text" class="form-control @error('ay_desc') is-invalid @enderror" name="ay_desc" value="{{ old('ay_desc') }}" required autocomplete="off">

									@error('ay_desc')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-6 offset-md-4">
									<button type="submit" class="btn btn-primary">
										{{ __('Save A.Y.') }}
									</button>
								</div>
							</div>
						</form>
					</div><!-- close card-body -->
				</div><!--close card-->

			</div> <!--close col-8 -->

		</div> <!-- close row -->



@endsection
