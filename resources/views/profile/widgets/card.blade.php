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
<div class="panel prof" style="box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.16);border-radius: 0;border-top-right-radius: 8px;border-bottom-right-radius: 8px;width: 290px;margin-bottom: 35px;border: none;">
    <img class="cover @if($user->sex == 1){{ 'female' }}@endif" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample87.jpg"/>
    <figcaption>
        <a href="{{ url('/'.$user->username) }}"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/profile-sample4.jpg" alt="profile-sample4" class="profile" /></a>
        <h2>{{ $user->name }}<span style="color:#e44d3a;">{{ '@'.$user->username }}</span></h2>
        <!-- <a href="{{ url('/'.$user->username) }}" class="info">View Profile</a> -->
    </figcaption>
</div>