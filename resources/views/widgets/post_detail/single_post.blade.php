
<div class="panel panel-default panel-google-plus panel-post" id="panel-post-{{ $post->id }}">
    @if($post->checkOwner($user->id))
    <div class="dropdown">
        <span class="dropdown-toggle" type="button" data-toggle="dropdown" id="dd1">
            <span class="glyphicon glyphicon-chevron-down"></span>
        </span>
        <ul class="dropdown-menu" aria-labelledby="dd1">
            <li><a href="javascript:;" onclick="deletePost({{ $post->id }})"><i class="fa fa-fw fa-trash" aria-hidden="true"></i> Hapus</a></li>
            <li><a href="javascript:;" onclick="editPost({{ $post->id }})"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i> Edit
            </a></li>
        </ul>
    </div>
    <div class="modalpost"></div> 
    @endif  
    <div class="panel-heading" style="background:none;">
        <img class="img-circle pull-left" src="{{ $post->user->getPhoto(60,60) }}" alt="{{ $post->user->name }}" />
        <a href="{{ url('/'.$post->user->username) }}"><h3 style="margin-top: 3px !important;color: #222;">{{ $post->user->name }}</h3></a>
        <h5><span>{{ '@'.$post->user->username }}</span> - <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</span> </h5>
    </div>
    <div class="panel-body" style="padding-bottom: 0;">
        <p>{{ $post->content }}</p>
        @foreach($post->images()->get() as $image)
        @if($image->file_path != 0 OR $image->file_path != NULL )
        <?php $file = explode(',',$image->file_path); ?>
        @for($i = 0; $i < count($file); $i++)
        <p><a href="{{url('storage/uploads/posts/'.$file[$i])}}">Download File</a></p>
        @endfor
        @elseif($image->image_path != 0 OR $image->image_path != NULL)
        <?php $apa = explode(',',$image->image_path); ?>
        @for($i = 0; $i < count($apa); $i++)
        <a data-fancybox="gallery" href="{{ url('storage/uploads/posts/'.$apa[$i]) }}" data-caption="{{ $post->content }}"><img class="img-responsive post-image" src="{{ url('storage/uploads/posts/'.$apa[$i]) }}" style="width: 320px;height: 320px;display: inline-block;padding: 0 5px 10px 0;"></a>
        @endfor
        @else
        kosong
        @endif
        @endforeach
        <hr class="fix-hr">
        <div class="comments-title">
            @include('widgets.post_detail.comments_title')
        </div>
        <div class="post-comments">
            @foreach($post->comments()->limit($comment_count)->orderBY('id', 'DESC')->with('user')->get()->reverse() as $comment)

            @include('widgets.post_detail.single_comment')

            @endforeach
        </div>
    </div>
    <div class="panel-footer">
        <div class="like-box">
            <button class="btn btn-default" style="background-color: transparent;background:none;">
                <a href="javascript:;" onclick="likePost({{ $post->id }})" class="like-text" style="color: #d5483c;">

                    @if($post->checkLike($post->user->id))
                    <i class="fa fa-heart"></i> <span>unlike!</span>
                    @else
                    <i class="fa fa-heart-o"></i> <span>like!</span>
                    @endif
                </a>
            </button>
            <button class="btn btn-default" style="padding: 0;background: none;padding: 0;border: none;box-shadow: none;margin-left: 4px;">
                <a href="javascript:;" class="all_likes" onclick="showLikes({{ $post->id }})">
                    <span>{{ $post->getLikeCount() }} @if($post->getLikeCount() > 1){{ 'Suka' }}@else{{ 'Suka' }}@endif</span>
                </a>
            </button>
        </div>
        <!-- <div class="input-placeholder">Add a comment...</div> -->
    </div>
    <div class="panel-google-plus-comment" style="display: block;">
        <img class="img-circle" src="{{ $user->getPhoto(40,40) }}" alt="User Image" />
        <div class="panel-google-plus-textarea">
            <form id="form-new-comment">
                <textarea rows="4" style="width: 100%;resize: none;" name="comment"></textarea>
                <a href="javascript:void(0)" class="btn btn-warning" onclick="submitComment({{ $post->id }})">Bagikan Komentar</a>
            </form>
            <!-- <button type="reset" style="margin-top: -34px;margin-right: 0;float: right;" class="btn btn-default">Cancel</button> -->
        </div>
        <div class="clearfix"></div>
    </div>
</div>