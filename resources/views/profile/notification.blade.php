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
                            <ul class="list-group">
                            @foreach($notes as $note)  
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span style="font-size: 20px;">
                                  <strong><b><i>{{ $note->name }}</i></b></strong>
                                </span>
                                  {{ $note->note }}
                                <span class="badge badge-primary badge-pill">
                                  {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
                                </span>
                              </li>
                            @endforeach
                            </ul>
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
