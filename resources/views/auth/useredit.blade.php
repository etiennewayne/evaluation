@extends('layouts.admin-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update User') }}</div>

                <div class="card-body">
                    <form method="POST" action="/cpanel-users/{{ $user->user_id}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" value="{{ $user->username }}" required autocomplete="off" readonly>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position_id" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>
                            <div class="col-md-6">
                                  
                                <select name="position_id" class="form-control">
                                 
                                    @foreach($positions as $pos)
                                        @if($user->positions->position_id == $pos->position_id)
                                            <option selected="selected" value="{{$pos->position_id}}">{{ $pos->position }}</option>
                                        @else
                                            <option value="{{$pos->position_id}}">{{ $pos->position }}</option>
                                        @endif
                                        
                                    @endforeach
                                </select>

                                {{-- @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }}</label>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ $user->lname }}" required autocomplete="off" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('Firstname') }}</label>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ $user->fname }}" required autocomplete="off" autofocus>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mname" class="col-md-4 col-form-label text-md-right">{{ __('Middlename') }}</label>

                            <div class="col-md-6">
                                <input id="mname" type="text" class="form-control" name="mname" value="{{ $user->mname }}" autocomplete="off" autofocus>
{{-- 
                                @error('mname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Sex') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="sex">
                                @if ($user->sex == 'MALE')
                                    <option selected="selected" value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                @elseif ( $user->sex == 'FEMALE')
                                   
                                    <option selected="selected" value="FEMALE">FEMALE</option>
                                    <option value="MALE">MALE</option>
                                @endif

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="civilstatus" class="col-md-4 col-form-label text-md-right">{{ __('Civil Status') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="civilstatus">
                                @foreach ($civilstatus as $c)
                                    @if ($user->civil_status == $c->civil_status)
                                        <option selected="selected" value="{{$c->civil_status}}">{{ $c->civil_status }}</option>
                                    @else
                                        <option value="{{ $c->civil_status }}">{{ $c->civil_status }}</option>
                                    @endif
                                        
                                @endforeach
                                </select>
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="program_id" class="col-md-4 col-form-label text-md-right">{{ __('Program') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="program_id">
                                @foreach ($programs as $p)
                                    @if ($user->programs->program_id == $p->program_id)
                                        <option selected="selected" value="{{$p->program_id}}">{{ $p->program_code }}</option>
                                    @else
                                        <option value="{{$p->program_id}}">{{ $p->program_code }}</option>
                                    @endif
                                        
                                @endforeach
                                </select>
                            </div>
                        </div> 


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div> 



                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
