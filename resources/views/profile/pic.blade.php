@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        @include('profile.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{ ucwords(auth::user()->name) }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Change your profile Picture <br><br>   
                    <img src="/img/{{ auth::user()->pic }}" width="200px" height="160px" alt=""><br>
                    <form method="post" action="{{ route('uploadImage') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="pic" class="form-control">
                        <input type="submit" class="btn btn-success">
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
