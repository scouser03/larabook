@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        @include('profile.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div align="center"  class="panel-heading"><b>Welcome your profile</b></div>
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
                                <a href="{{ url('/edit/profile') }}" class="btn btn-primary">Edit Profile</a>
                            </center>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <h4><span class="label label-primary">About</span></h4>
                        {{ $data->about }}
                    </div>    
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
