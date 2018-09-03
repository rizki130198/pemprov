
<div class="media" id="post-comment-{{ $comment->id }}">
    <div class="media-left">
        <a href="{{ url('/'.$comment->user->username) }}">
            <img class="media-object img-circle comment-profile-photo" src="{{ $comment->user->getPhoto(60,60) }}">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading" style="color: #333;">{{ $comment->user->name }}
            @if($dataevent->id_users == Auth::id() || $comment->id_users == Auth::id())
            <a href="javascript:;" class="remove" onclick="removeCommentevent({{ $comment->id }}, {{ $dataevent->id_events }})"><i class="fa fa-times" style="color: red;"></i></a>
            @endif
            <small class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at->diffForHumans() }}</small>
        </h4>
        <p style="color: #888;margin-top: -3px;font-weight: 100;">{{ '@'.$comment->user->username }}</p>
        <!-- <span class="date pull-right" style="position: absolute;right: 0;bottom: 0;">
            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at->diffForHumans() }}
        </span> -->
        <p style="font-weight: 100;">{{ $comment->komentar }}</p>
    </div>
</div>

<div class="clearfix"></div>

<hr />