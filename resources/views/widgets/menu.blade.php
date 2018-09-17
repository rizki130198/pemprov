<div class="hide-menu">
    <h4 style="color: #61677;margin-bottom: 20px; font-size: 15px;letter-spacing: 1px;margin-left: 30px;"><strong>Jelajahi</strong></h4>
    <ul class="menu-explore">
        <a href="{{ url('/') }}"><li class="{{ request()->is('home') ? 'active' : '' }}"><i class="fa fa-home" style="color: #339399;"></i>Beranda</li></a>
        <a href="{{ url('/events') }}">
        	<li class="{{ request()->is('events') ? 'active' : '' }}"><i class="fa fa-calendar" style="color: #abc554;"></i>Acara <span class="hitung_event badge" style="float: right;background-color: #abc554;">{{sHelper::countevent()}}</span></li>
        </a>
        <a href="{{ url('/groups') }}"><li class="{{ Request::segment(1) == 'group' || Request::segment(1) == 'groups' ? 'active' : '' }}"><i class="fa fa-users" style="color:#e17e41;"></i>Grup</li></a>
        <a href="{{ url('/direct-messages') }}"><li class="{{ request()->is('direct-messages') ? 'active' : '' }}"><i class="fa fa-commenting" style="color: #d5483c;"></i>Pesan</li></a>
    </ul>
</div>