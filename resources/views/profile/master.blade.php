<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/53068421a1.js"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    @auth
                        <a class="navbar-brand" href="{{ url('/profile') }}/{{ Auth::user()->slug }}">
                            Profile
                        </a>
                        <a class="navbar-brand" href="{{ url('/find-friends') }}">
                            Find Friends
                        </a>
                        <a class="navbar-brand" href="{{ url('/requests') }}">
                            Requests 
                                @if(App\Friendship::where('status',0)->where('user_requested', Auth::user()->id)->count() != 0)
                                <span style="margin-top: -10px; font-size: 10px;" class="badge badge-light">
                                    {{ App\Friendship::where('status',0)->where('user_requested', Auth::user()->id)->count() }}
                                </span>
                                @endif
                        </a>
                    @endauth
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else   
                            <li>
                                <a class="navbar-brand" href="{{ url('/friends') }}">
                                    <i class="fa fa-users fa-lg" aria-hidden="true"></i> <span style="margin-top: -10px; font-size: 10px;" class="badge badge-light">
                                    </span>
                                </a>
                            </li>
    
                            <li class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-globe fa-2x" aria-hidden="true"></i>
                                    @php
                                        $notiCount = App\Notification::where('status',1)
                                                            ->where('user_logged',Auth::user()->id)
                                                            ->count();
                                    @endphp
                                    @if($notiCount != 0)
                                        <span class="badge" style="background: red; margin-top:-30px; margin-left:-12px;">
                                             {{ $notiCount }}
                                        </span>
                                    @endif
                                </a>
                                @php
                                    $notes = DB::table('users')
                                                ->where('status',1)
                                                ->leftJoin('notifications', 'users.id', 'notifications.user_hero')
                                                ->where('user_logged',Auth::user()->id)
                                                ->orderBy('notifications.id','Desc')
                                                ->get();
                                @endphp 
                                <ul class="dropdown-menu">
                                    @if(count($notes))
                                        @foreach ($notes as $note)
                                            <li>
                                                <a href="{{ url('/notifications') }}/{{ $note->id }}"><b>{{ $note->name }}</b> {{ $note->note }}</a>
                                            </li>
                                        @endforeach
                                    @else
                                    <li>
                                        <a href="">You don't new notification !</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    <img style="border-radius: 50%" src="/img/{{ auth::user()->pic }}" width="30px" height="30px" alt="">
                                     <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('/edit/profile') }}">
                                            Edit Profile
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li> 
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
