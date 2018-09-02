<!-- <a href="{{ url('/post/'.$post->id) }}"> -->
    <div class="panel panel-default panel-google-plus panel-post" id="panel-postgrup-{{ $post->id_post_grup }}">
        @if($post->checkOwner($user->id))
        <div class="dropdown">
            <span class="dropdown-toggle" type="button" data-toggle="dropdown" id="dd1">
                <span class="glyphicon glyphicon-chevron-down"></span>
            </span>
            <ul class="dropdown-menu" aria-labelledby="dd1">
                <li><a href="javascript:;" onclick="deletePostgrup({{ $post->id_post_grup }})"><i class="fa fa-fw fa-trash" aria-hidden="true"></i> Delete</a></li>
            </ul>
        </div>
        @endif
<!--         <div class="panel-google-plus-tags">
            <ul>
                <li>#Millennials</li>
                <li>#Generation</li>
            </ul>
        </div> -->
        <div class="panel-heading" style="background:none;">
            <img class="img-circle pull-left" src="{{ $user->getPhoto(60,60) }}" alt="{{ $user->name }}" />
            <a href="{{ url('/'.$user->username) }}"><h3 style="margin-top: 3px !important;color: #222;">{{ $user->name }}</h3></a>
            <h5><span>{{ '@'.$user->username }}</span> - <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</span> </h5>
        </div>
        <div class="panel-body">
            <p>{{ $post->content }}</p>
            @if($post->hasImage())
            @foreach($post->images()->get() as $image)

            @if($image->image_path ==NULL)
            <p><a href="{{$image->getFile()}}">Download File</a></p>
            @else
            <a data-fancybox="gallery" href="{{ $image->getURL() }}" data-caption="{{ $post->content }}"><img class="img-responsive post-image" src="{{ $image->getURL() }}"></a>
            @endif
            @endforeach
            @endif
            <hr class="fix-hr">
            <div class="comments-title-grup">
                @include('groups.widgets.post_detail.comments_title')
            </div>
            <div class="post-comments-grup">
                @foreach($post->comments()->limit($comment_count)->orderBY('id', 'DESC')->with('user')->get()->reverse() as $comment)

                @include('groups.widgets.post_detail.single_comment')

                @endforeach
            </div>
        </div>
        <div class="panel-footer">
            <div class="like-box">
                <button class="btn btn-default" style="background-color: transparent;background:none;">
                    <a href="javascript:;" onclick="likePostgrup({{ $post->id_post_grup }})" class="like-text">
                        @if($post->checkLike($user->id))
                        <i class="fa fa-heart"></i> Unlike!
                        @else
                        <i class="fa fa-heart-o"></i> Like!
                        @endif
                    </a>
                </button>
                <button class="btn btn-default" style="padding: 0;background: none;padding: 0;border: none;box-shadow: none;margin-left: 4px;">
                    <a href="javascript:;" class="all_likes" onclick="showLikesGrup({{ $post->id_post_grup }})">
                        <span>{{ $post->getLikeCount() }} @if($post->getLikeCount() > 1){{ 'likes' }}@else{{ 'like' }}@endif</span>
                    </a>
                </button>
            </div>
            <div class="input-placeholder">Add a comment...</div>
        </div>
        <div class="panel-google-plus-comment">
            <img class="img-circle" src="{{ $user->getPhoto(40,40) }}" alt="User Image" />
            <div class="panel-google-plus-textarea">
                <form id="form-new-comment-grup">
                    <textarea rows="4" style="width: 100%;resize: none;"></textarea>
                    <ahref="javascript:void(0)" class="btn btn-warning" onclick="submitCommentgrup({{ $post->id_post_grup }})">Post comment</a>
                </form>
                <button type="reset" style="margin-top: -34px;margin-right: 0;float: right;" class="btn btn-default">Cancel</button>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- </a> -->


<!-- <div class="panel panel-default panel-post" id="panel-post-{{ $post->id_post_grup }}">
    <div class="panel-body">
        <div class="pull-left">
            <a href="#">
                <img class="media-object img-circle post-profile-photo" src="{{ $user->getPhoto(60,60) }}">
            </a>
        </div>
        <div class="pull-left info">
            <a href="{{ url('/'.$user->username) }}" class="name">{{ $user->name }}</a>
            <a href="{{ url('/'.$user->username) }}" class="username">{{ '@'.$user->username }}</a>
            <a href="{{ url('/post/'.$post->id) }}" class="date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</a>
        </div>
        <div class="pull-right like-box">
            <a href="javascript:;" onclick="likePost({{ $post->id_post_grup }})" class="like-text">
                @if($post->checkLike($user->id))
                <i class="fa fa-heart"></i> <span>Unlike!</span>
                @else
                <i class="fa fa-heart-o"></i> <span>Like!</span>
                @endif
            </a>
            <div class="clearfix"></div>
            <a href="javascript:;" class="all_likes" onclick="showLikes({{ $post->id_post_grup }})"><span>{{ $post->getLikeCount() }} @if($post->getLikeCount() > 1){{ 'likes' }}@else{{ 'like' }}@endif</span></a>
        </div>
        <div class="clearfix"></div>
        <span>
            @if($post->checkOwner($user->id))
            <div class="navbar-right">
                <div class="dropdown">
                    <button class="btn btn-link btn-xs dropdown-toggle" type="button" id="dd1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dd1" style="float: right;">
                        <li><a href="javascript:;" onclick="deletePost({{ $post->id_post_grup }})"><i class="fa fa-fw fa-trash" aria-hidden="true"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
            @endif
        </span>
        <hr class="fix-hr">
        <div class="post-content post-content-s">
            {{ $post->content }}
            @if($post->hasImage())
            @foreach($post->images()->get() as $image)
            <a data-fancybox="gallery" href="{{ $image->getURL() }}" data-caption="{{ $post->content }}"><img class="img-responsive post-image" src="{{ $image->getURL() }}"></a>
            @endforeach
            @endif
        </div>
        <hr class="fix-hr">
        <div class="comments-title">
            @include('widgets.post_detail.comments_title')
        </div>
        <div class="post-comments">

            @foreach($post->comments()->limit($comment_count)->orderBY('id', 'DESC')->with('user')->get()->reverse() as $comment)

            @include('widgets.post_detail.single_comment')


            @endforeach

        </div>

        <div class="clearfix"></div>
        <div class="media post-write-comment">
            <form id="form-new-comment">
                <div class="pull-left">
                    <a href="{{ url('/'.$user->username) }}">
                        <img class="media-object img-circle" src="{{ $user->getPhoto(60,60) }}">
                    </a>
                </div>
                <div class="media-body">
                    <textarea class="form-control" rows="1" placeholder="Comment"></textarea>
                </div>
                <button type="button" class="btn btn-default btn-xs pull-right" onclick="submitComment({{ $post->id_post_grup }})">
                    Submit!
                </button>
            </form>
        </div>
    </div>
</div> -->
