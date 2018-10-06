<div class="panel-default post-comment" id="post-comments-grup-{{ $comment->id }}">
    <div class="commet">
    <div class="pull-left" style="padding-right: 12px;">
        <a href="{{ url('/'.$comment->user->username) }}">
            <img class="media-object img-circle comment-profile-photo" src="{{ $comment->user->getPhoto(60,60) }}">
        </a>
    </div>
    <div class="pull-left comment-info">
        <a href="{{ url('/'.$comment->user->username) }}" class="name">{{ $comment->user->name }}</a>
        <!-- <a href="{{ url('/'.$comment->user->username) }}" class="username">{{ '@'.$comment->user->username }}</a> -->
        <span class="date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at->diffForHumans() }}</span>
        @if($post->user_id == Auth::id() || $comment->comment_user_id == Auth::id())
        <a href="javascript:;" class="remove pull-right" onclick="removeCommentGrup({{ $comment->id }}, {{ $post->id_post_grup }})" style="margin-left: 5px;color: red;"><i class="fa fa-times"></i></a>
        @endif
        <div class="clearfix"></div>
    </div>
    <br />
    <p>
        {{ $comment->comment }}
    </p>
</div>
</div>

<div class="clearfix"></div>

<hr />