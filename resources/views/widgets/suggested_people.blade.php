<div class="panel-follow">
    <div class="panel-heading" style="border-bottom: solid 1px #ddd;padding-right: 20px;padding-left: 20px;"><h4><strong>Saran Teman</strong></h4></div>
    <div class="panel-body" style="padding-right: 20px;padding-left: 20px;">
        @foreach(Auth::user()->suggestedPeople(10) as $user)
        <div class="media">
            <div class="media-left">
                <a href="{{ url('/'.$user->username) }}">
                    <img class="media-object" src="{{ $user->getPhoto(50, 50) }}" alt="{{ url('/'.$user->username) }}" width="50px" height="50px" style="border-radius: 50%;padding: 3px;border: 2px solid #e8b563;">
                </a>
            </div>
            <div class="media-body">
                <a href="{{ url('/'.$user->username) }}" style="text-decoration: none;"><h4 class="media-heading" style="font-size: 14px;font-weight: bold;margin-top: 7px;">{{ $user->name }}</h4></a>
                <p style="margin-top: -2px;font-size: 14px;">{{ '@'.$user->username }}
                    <div id="people-listed-{{ $user->id }}" style="float: right;margin-top: -45px;">
                        {!! sHelper::followButton($user->id, Auth::id(), '#people-listed-'.$user->id, 'btn-sm') !!}
                    </div>
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
