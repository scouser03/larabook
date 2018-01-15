@extends('profile.master')
@section('content')
<div class="container">
    <div class="row">
        @include('profile.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucwords(auth::user()->name) }}</div>

                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="card">  
                          <div class="card-body">
                            @foreach($allUsers as $user)
                                <div class="thumbnail col-md-4" style="margin: 5px">
                                   <h2 align="center">{{ ucwords($user->name) }}</h2>
                                   <center>  
                                       <img style="border-radius: 50%" class="img-thumbnail" src="/img/{{ $user->pic }}" width="150px" height="120px" alt=""><br>
                                   </center>
                                   <p align="center">{{ $user->profile->city }} - {{ $user->profile->country }}</p>
                                   @php
                                        $check = DB::table('friendships')
                                                ->where('requester', Auth::user()->id)
                                                ->where('user_requested', $user->id)
                                                ->first()    
                                   @endphp

                                   @if(!$check)
                                       <p align="center">
                                            <a href="{{ url('addFriend') }}/{{ $user->id }}" class="btn btn-success">Add to friend</a>
                                        </p>
                                   @else 
                                        <p align="center">
                                            <a href="" class="btn btn-success">request sent</a>
                                        </p>
                                    @endif    
                                    
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
