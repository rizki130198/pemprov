    <div class="panel panel-default panel-google-plus panel-postgrup" id="panel-postgrup-{{ $post->id_post_grup }}">
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
        <div class="panel-heading" style="background:none;">
            <img class="img-circle pull-left" src="{{ $post->$user->getPhoto(60,60) }}" alt="{{ $post->$user->name }}" />
            <a href="{{ url('/'.$post->$user->username) }}"><h3 style="margin-top: 3px !important;color: #222;">{{ $post->$user->name }}</h3></a>
            <h5><span>{{ '@'.$post->$user->username }}</span> - <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</span> </h5>
        </div>
        <div class="panel-body">
            <p>{{ $post->content }}</p>
            @if($post->hasImage())
            @foreach($post->images()->get() as $image)
            @if($image->image_path == NULL)

            <?php $file = explode(',',$image->file_path); ?>
            @for($i = 0; $i < count($file); $i++)
            <p><a href="{{url('storage/uploads/posts/'.$file[$i])}}">Download File</a></p>
            @endfor
            @else
            <?php $image = explode(',',$image->image_path); ?>
            @for($i = 0; $i < count($image); $i++)
            <a data-fancybox="gallery" href="{{ url('storage/uploads/posts/'.$image[$i]) }}" data-caption="{{ $post->content }}"><img class="img-responsive post-image" src="{{ url('storage/uploads/posts/'.$image[$i]) }}" style="width: 320px;height: 320px;display: inline-block;padding: 0 5px 10px 0;"></a>
            @endfor
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
                    <a href="javascript:;" onclick="likePostgrup({{ $post->id_post_grup }})" class="like-text" style="color: #d5483c;">
                        @if($post->checkLike($post->$user->id))
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
            <img class="img-circle" src="{{ $post->$user->getPhoto(40,40) }}" alt="User Image" />
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