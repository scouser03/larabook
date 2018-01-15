@extends('profile.master')
@section('content')
<div class="container">
    <div class="row">
        @include('profile.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucwords(auth::user()->name) }}'s Friends</div>

                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="card">  
                          <div class="card-body">
                            @if (session('msg'))
                                <div class="alert alert-success">
                                    {{ session('msg') }}
                                </div>
                            @endif
                            @foreach($friends as $user)
                                <div class="thumbnail col-md-4" style="margin: 5px">
                                   <h2 align="center">{{ ucwords($user->name) }}</h2>
                                   <center>  
                                       <img style="border-radius: 50%" class="img-thumbnail" src="/img/{{ $user->pic }}" width="150px" height="120px" alt=""><br>
                                   </center><br>
                                   <p align="center">Gender: <b>{{ $user->gender }}</b></p>
                                   <p align="center">Email: <b>{{ $user->email }}</b></p>
                                      <p align="center">
                                          <a href="" class="btn btn-success">Unfriend</a>
                                      </p>                                
                                </div>
                            @endforeach    
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-2">  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
