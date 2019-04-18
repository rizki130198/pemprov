<div class="hide-menu">
    <h4 style="color: #616770;font-size: 15px;letter-spacing: 1px;margin-left: 30px;"><strong>Jelajahi</strong></h4>
    <ul class="menu-explore">
    	<a href="{{ url('/news') }}"><li class="{{Request::segment(1) == 'news' ? 'active' : '' || Request::segment(1) == 'baca' ? 'active' : '' }}"><i class="fa fa-th-large" style="color: #42a5f5;"></i>Berita Terbaru</li></a>
        <a href="{{ url('/') }}"><li class="{{ request()->is('home') ? 'active' : '' }}"><i class="fa fa-home" style="color: #00cec9;"></i>Postingan</li></a>
        <a href="{{ url('/events') }}">
        	<li class="{{ request()->is('events') ? 'active' : '' }}"><i class="fa fa-calendar" style="color: #f1c40f"></i>Acara <span class="hitung_event badge" style="float: right;background-color: #f1c40f;">{{sHelper::countevent()}}</span></li>
        </a>
        <!-- <a href="{{ url('/groups') }}"><li class="{{ Request::segment(1) == 'group' || Request::segment(1) == 'groups' ? 'active' : '' }}"><i class="fa fa-users" style="color:#e17e41;"></i>Grup</li></a> -->
        <!-- <a href="{{ url('/direct-messages') }}"><li class="{{ request()->is('direct-messages') ? 'active' : '' }}"><i class="fa fa-commenting" style="color: #e74c3c;"></i>Pesan</li></a> -->
        @if($user->role == 'admin')
        <a href="{{ url('/pengguna') }}"><li class="{{ request()->is('pengguna') ? 'active' : '' }}"><i class="fa fa-user" style="color: #7f8c8d;"></i>Pengguna</li></a>
        @endif
        <a href="{{ url('/spj') }}"><li class="{{ request()->is('spj') ? 'active' : '' }}"><i class="fa fa-money" style="color: #2ecc71;"></i>SPJ</li></a>
    </ul>
</div>