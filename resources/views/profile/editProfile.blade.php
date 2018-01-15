@extends('profile.master')
@section('content')
<div class="container">
    <div class="row">
        @include('profile.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucwords(auth::user()->name) }}</div>

                <div class="panel-body">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card" style="width: 18rem;">  
                          <div class="card-body">
                            <h5 align="center" class="card-title">{{ ucwords(auth::user()->name) }}</h5>
                            <center>  
                                <img style="border-radius: 50%" class="img-thumbnail" src="/img/{{ auth::user()->pic }}" width="120px" height="80px" alt=""><br>
                            </center>
                            <p align="center" class="card-text">{{ $data->city }} - {{ $data->country }} </p>
                            <center>  
                                <a href="{{ route('profilePhoto') }}" class="btn btn-primary">Change Photo</a>
                            </center>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-2">  
                    </div>
                    <form method="post" action="{{ url('/updateProfile') }}">
                        {{ csrf_field() }}
                        
                        <div class="col-sm-6 col-lg-6">
                            <h4><span class="label label-default">Update profile detiles</span></h4>
                            @if (Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <strong>{{ Session::get('message') }}</strong>
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Change city</label>
                                <input class="form-control" type="text" name="city" value="{{ $data->city }}">
                            </div>

                            <div class="form-group">
                                <label>Change country</label>
                                <input class="form-control" name="country" type="text" value="{{ $data->country }}">
                            </div>
                            <div class="form-group">
                                <label>Change about</label>
                                <textarea class="form-control" name="about" cols="30" rows="5">{{ $data->about }}</textarea>
                            </div>

                        </div> 
                        <div class="col-lg-12">
                            <button class="btn btn-success btn-block">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
