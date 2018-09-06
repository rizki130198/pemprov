<!-- <div class="user-card">
    <div class="cover @if(!$user->getCover()){{ 'no-cover' }}@endif" style="background-image: url('{{ $user->getCover() }}')"></div>
    <div class="detail">
        <div class="image">
            <a data-fancybox="group" href="{{ $user->getPhoto() }}">
                <img class="img-circle @if($user->sex == 1){{ 'female' }}@endif" src="{{ $user->getPhoto(70, 70) }}" alt="" />
            </a>
        </div>
        <div class="info">
            <a href="{{ url('/'.$user->username) }}" class="name">{{ $user->name }}</a>
            <a href="{{ url('/'.$user->username) }}" class="username">{{ '@'.$user->username }}</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div> -->
<style type="text/css">
    .tooltip-inner{
        float: left;
        text-align: left;
        padding: 10px 15px;
    }
    .nav-pills li.active a{
        background-color: #fac959;
    }
    .nav-pills li.active a:hover{
        background-color: #fac959 !important;
    }
    .nav-pills li a{
        color: #1d2129;
        padding: 8px 15px;
    }
    @media(max-width: 768px){
        .nav-pills{
            display: none;
        }
        .h-20{
            display: none;
        }
    }
</style>
@if (Request::segment(1) == 'group')
<ul class="nav nav-pills nav-stacked" style="max-width: 300px;padding-left: 55px;margin-bottom: 20px;">
    <h2 style="margin-bottom: 5px;">{{ $group->nama_grup }}</h2>
    @if($group->status_grup == 'public')
    <label style="color: #90949c;margin-bottom: 20px;"  data-toggle="tooltip" data-placement="bottom" title="Siapa pun dapat menemukan group. melihat siapa anggotanya dan postingan mereka"><i class="glyphicon glyphicon-globe"></i> Group Public</label>
    @elseif($group->status_grup == 'tertutup')
    <label style="color: #90949c;margin-bottom: 20px;"  data-toggle="tooltip" data-placement="bottom" title="Siapa pun dapat menemukan group. hanya anggota yang dapat melihat siapa anggotanya dan postingan mereka."><i class="glyphicon glyphicon-lock"></i> Group Tertutup</label>
    @elseif($group->status_grup == 'rahasia')
    <label style="color: #90949c;margin-bottom: 20px;"  data-toggle="tooltip" data-placement="bottom" title="Siapa pun tidak dapat menemukan group, hanya admin yang dapat menemukan. anggota dapat melihat siapa anggotanya dan postingan mereka."><i class="glyphicon glyphicon-eye-close"></i> Group Rahasia</label>
    @endif
    <li role="presentation" class="{{ Request::segment(2) == 'diskusi' ? 'active' : '' }}"><a href="{{ url('/group/diskusi/'.$group->id_grup) }}">Diskusi</a></li>
    <li role="presentation" class="{{ Request::segment(2) == 'anggota' ? 'active' : '' }}"><a href="{{ url('/group/anggota/'.$group->id_grup) }}">Anggota</a></li>
    <li role="presentation" class="{{ Request::segment(2) == 'foto' ? 'active' : '' }}"><a href="{{ url('/group/foto/'.$group->id_grup) }}">Foto</a></li>
    @if($group->id_grup !== 'id_user')
    <li role="presentation" class="{{ Request::segment(2) == 'pengaturan_group' ? 'active' : '' }}"><a href="{{ url('/group/pengaturan_group/'.$group->id_grup) }}">Pengaturan Grup</a></li>
    @else
    @endif
</ul>
@else
<div class="panel prof" style="box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.16);border-radius: 0;border-top-right-radius: 8px;border-bottom-right-radius: 8px;width: 290px;margin-bottom: 35px;border: none;">
    @if(!$user->getCover())
    <img class="cover" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample87.jpg"/>
    @else
    <img class="cover" src="{{ $user->getCover() }}"/>
    @endif
    <figcaption>
        <a href="{{ url('/'.$user->username) }}"><img src="{{ $user->getPhoto(70, 70) }}" alt="profile-sample4" class="profile" /></a>
        <h2>{{ $user->name }}<span style="color:#e44d3a;">{{ '@'.$user->username }}</span></h2>
        <!-- <a href="{{ url('/'.$user->username) }}" class="info">View Profile</a> -->
    </figcaption>
</div>
@endif