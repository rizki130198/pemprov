<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/pace-master/themes/white/pace-theme-flash.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/fancybox/dist/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/around.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    @yield('header')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-fixed-bottom" style="z-index: 1;">
            <div class="icon-bar">
                <a class="active" href="{{ url('/home') }}"><i class="fa fa-home"></i></a> 
                <a href="#" class="collapsed" data-toggle="collapse" data-target="#search"><i class="fa fa-search"></i></a> 
                <a href="#" onclick="openNotif()">
                    <i class="fa fa-bell"></i>
                    @if(count(sHelper::notifications()) > 0)
                    <span class="badge badge-notify" style="top: 8px;right: 33%;position: absolute;">{{ count(sHelper::notifications()) }}</span>
                    @endif
                </a> 
                <a href="#" onclick="openNav()"><i class="fa fa-bars"></i></a> 
            </div>
        </nav>
        <nav class="navbar navbar-default flex-nav navbar-static-top navbar-around" role="navigation">
            <div class="side-nav" id="side-nav">
                <div class="overlay"></div>
                <style type="text/css">
                .faq ul.timeline li.timeline-inverted:target {
                    display:block !important;
                }
            </style>
            <div class="navigation" style="text-align: center;">
                <div class="content-navigation" style="padding-left: 20px;padding-right: 20px;">
                    @if(count($user_list) == 0)
                    <a href="{{ url('/direct-messages') }}">
                        <div id="messages" class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.7);border-radius: 16px;border: none;">
                            <div class="panel-body" style="color: #111;font:inherit;">
                                See all messages
                            </div>
                        </div>    
                    </a>
                    @else
                    @foreach($user_list as $friend)
                    <a href="{{ url('/direct-messages/show/'. $friend['user']->id) }}" class="friend">
                        <div id="messages" class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.7);border-radius: 16px;border: none;margin-top: 50px;">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="float: left;font:inherit;color: #111;">Messages</h3>
                                <span style="float: right;color: #111;">{{ $friend['message']->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="img-circle" src="{{ $friend['user']->getPhoto(40, 40) }}">
                                        </a>
                                    </div>
                                    <div class="media-body" style="color: #111;font:inherit;">
                                        <h4 class="media-heading" style="float: left;"><strong>{{ $friend['user']->name }}</strong></h4>
                                        <br>
                                        <br>
                                        <p style="float: left;margin-top: -18px;">{{ str_limit($friend['message']->message, 20) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                    <i class="fa fa-times-circle" data-toggle="collapse" data-target="#side-nav" style="font-size: 16px;margin-top:18%;"></i>
                    <p data-toggle="collapse" data-target="#side-nav" style="font-size: 20px;line-height: 35px;padding-bottom: 50px;">Close</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <button type="button" style="padding:0;padding-right: 10px;border:none;background-color: transparent;color: #fff;font-size: 30px;" class="navbar-toggle toggle-side-nav" data-toggle="collapse" data-target="#side-nav">
                    <i class="fa fa-commenting"></i>
                    @if (Request::segment(1) == 'direct-messages')
                        @else
                        <span class="badge badge-notify" style="right: 2px;top: 2px;">{{ count($user_list) }}</span>
                        @endif
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="" style="width: 210px;height: 40px;margin-top: 12px;" />
                </a>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <div class="navbar-form navbar-left">
                    <form id="custom-search-input" method="get" action="{{ url('/search') }}">
                        <div class="input-group col-md-12">
                            <input type="text" class="form-control input-lg" name="s" placeholder="search..." />
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-lg" type="button">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>


                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    @include('widgets.notifications')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle parent" data-toggle="dropdown" role="button" aria-expanded="false">

                            <img src="{{ Auth::user()->getPhoto() }}" alt="" />
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('/'.Auth::user()->username) }}">
                                    <i class="fa fa-user"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/settings') }}">
                                    <i class="fa fa-cog"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <style type="text/css">
    @media(max-width: 768px){
        .hide-search{
            display: block !important; 
        }
    }
</style>
<div class="collapse navbar-collapse hidden-lg" id="search">
    <form class="hidden-sm hidden-md hidden-lg" id="custom-search-input" method="get" action="{{ url('/search') }}" style="margin-bottom: 12px;margin-top: 12px;">

        <div class="input-group col-md-12">
            <input type="text" class="form-control input-lg" name="s" placeholder="search..." />
            <span class="input-group-btn">
                <button class="btn btn-info btn-lg" type="button">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </span>
        </div>
    </form>
</div>
</nav>
<!-- Tab Hamburger -->
<div id="mySidenav" class="sidenav">
    <div class="sidebar-header">
        <div class="user-pic">
            <img class="img-responsive img-rounded" src="{{ Auth::user()->getPhoto() }}" alt="User picture">
        </div>
        <div class="user-info">
            <span class="user-name"><strong>{{ Auth::user()->name }}</strong></span>
            <span class="user-role">{{ '@'.$user->username }}</span>
            <span class="user-status">
                <i class="fa fa-circle"></i>
                <span>Online</span>
            </span>
        </div>
    </div>    
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{ url('/events') }}">
                    <i class="fa fa-calendar" style="background:#abc554;"></i>
                    <span>Events</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/groups') }}">
                    <i class="fa fa-users" style="background:#e17e41;"></i>
                    <span>Groups</span>
                </a>
            </li>
            
            <li class="sidebar-dropdown">
                <a href="#">
                    <i class="fa fa-user" style="background:#339399; "></i>
                    <span>Profile</span>
                </a>
                <div class="sidebar-submenu" style="display: none;">
                    <ul>
                        <li>
                            <a href="{{ url('/'.Auth::user()->username) }}">My Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('/settings') }}">Setting</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off" style="background: #d5483c;"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
        <div style="text-align: center;">
            <a href="javascript:void(0)" onclick="closeNav()" style="color: #333;position: relative;">
                <i class="fa fa-times-circle" style="font-size: 16px;margin-top:18%;"></i>
                <p style="font-size: 20px;line-height: 35px;padding-bottom: 50px;">Close</p>
            </a>
        </div>
    </div>
</div>
<!-- End Tab Hamburger -->

<!-- Tab Notif -->
<div id="mySidenav2" class="sidenav" style="transition: 0s;"> 
    <div class="sidebar-menu">
        <ul class="list-group">
            @if(count(sHelper::notifications()) == 0)
            <li class="list-group-item">
               <div class="alert alert-success" role="alert">There is no notification.</div>
           </li>
           @else
           @foreach(sHelper::notifications() as $notification)
           <a href="{{ $notification['url'] }}">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading"><i class="fa {{ $notification['icon'] }}"></i>{{ $notification['text'] }}</h4>
                    </div>
                </div>
            </li>
        </a>
        @endforeach
        @endif
    </ul>
    <center>
        <a href="javascript:void(0)" onclick="closeNotif()" style="color: #333;bottom: 0;position: fixed;">
            <i class="fa fa-times-circle" style="font-size: 16px;margin-top:18%;"></i>
            <p style="font-size: 20px;line-height: 35px;padding-bottom: 50px;">Close</p>
        </a>
    </center>
</div>
</div>
<!-- End Tab Notif -->
</div>
<div class="main-content">
    @yield('content')
</div>

<div class="container">
    @include('widgets.footer')
</div>
</div>
<div class="loading-page">
    <img src="{{ asset('images/rolling.gif') }}" alt="">
</div>
@include('widgets.error')
<!-- Scripts -->
<script type="text/javascript">
    var BASE_URL = "{{ url('/') }}";
    var REQUEST_URL = "<?=Request::url()?>";
    var CSRF = "{{ csrf_token() }}";
    var WALL_ACTIVE = false;
</script>
<script src="{{ asset('plugins/jquery/jquery-2.1.4.min.js')  }}"></script>
<script src="{{ asset('plugins/pace-master/pace.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/jquery.serializeJSON/jquery.serializejson.min.js') }}"></script>
<script src="{{ asset('plugins/fancybox/dist/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="//maps.google.com/maps/api/js?key=<?=config('googlemaps.key')?>"></script>
<script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/gmaps/gmaps.min.js') }}"></script>
<script src="{{ asset('js/around.js') }}"></script>
<script src="{{ asset('js/wall.js') }}"></script>
<script src="{{ asset('js/notifications.js') }}"></script>
<script src="{{ asset('js/grup.js') }}"></script> 
<script src="{{ asset('js/event.js') }}"></script>
@yield('footer')
<script type="text/javascript">
    $(function () {
       $('.panel-google-plus, .panel-footer, .input-placeholder, .panel-google-plus, .panel-google-plus-comment, .panel-google-plus-textarea, button[type="reset"]').on('click', function(event) {
        var $panel = $(this).closest('.panel-google-plus');
        $comment = $panel.find('.panel-google-plus-comment');

        $comment.find('.btn:first-child').addClass('disabled');
        $comment.find('textarea').val('');

        $panel.toggleClass('panel-google-plus-show-comment');

        if ($panel.hasClass('panel-google-plus-show-comment')) {
            $comment.find('textarea').focus();
        }
    });
       $('.panel-google-plus-comment > .panel-google-plus-textarea > textarea').on('keyup', function(event) {
        var $comment = $(this).closest('.panel-google-plus-comment');

        $comment.find('button[type="submit"]').addClass('disabled');
        if ($(this).val().length >= 1) {
            $comment.find('button[type="submit"]').removeClass('disabled');
        }
    });
   });
    // @if(!Auth::user()->has('location'))

    // autoFindLocation();

    // @endif
</script>
<script type="text/javascript">
    $('.toggle-side-nav').on('click', function () {
        var targetId = $(this).data('target'); 
        var $sidenav;
        var $overlay;

        if (targetId) {
            $sidenav = $(targetId);
            $sidenav.addClass('open');

            $sidenav.find('.overlay').on('click', function () {
                $sidenav.removeClass('open');
                $(this).off('click');
            });
        }
    });
</script>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function openNotif() {
        document.getElementById("mySidenav2").style.width = "100%";
    }

    function closeNotif() {
        document.getElementById("mySidenav2").style.width = "0";
    }
</script>
<script type="text/javascript">
    jQuery(function ($) {
        $(".sidebar-dropdown > a").click(function () {
            $(".sidebar-submenu").slideUp(200);
            if ($(this).parent().hasClass("active")) {
                $(".sidebar-dropdown").removeClass("active");
                $(this).parent().removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this).next(".sidebar-submenu").slideDown(200);
                $(this).parent().addClass("active");
            }

        });
    });
</script>
</body>
</html>
