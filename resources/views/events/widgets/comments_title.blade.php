<p class="text-muted"><i class="fa fa-comment" aria-hidden="true"></i>
    <small>
        @if($dataevent->getCommentCount() > 0)
            @if($dataevent->getCommentCount() > 1){{ $dataevent->getCommentCount().' comments' }}@else{{ $dataevent->getCommentCount().' comment' }}@endif
        @else
            No Comments! Write a comment
        @endif
    </small>
</p>
<hr>
@if($dataevent->getCommentCount() > 2 && (empty($comment_count) || $comment_count < 3))
    <a class="btn btn-link btn-block btn-xs" href="{{ url('/post/'.$dataevent->id) }}"><i class="fa fa-bars" aria-hidden="true"></i> Show all comments</a>
@endif