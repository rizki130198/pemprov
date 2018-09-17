<p class="text-muted"><i class="fa fa-comment" aria-hidden="true"></i>
    <small>
        @if($dataevent->getCommentCount() > 0)
            @if($dataevent->getCommentCount() > 1){{ $dataevent->getCommentCount().' Komentar' }}@else{{ $dataevent->getCommentCount().' Komentar' }}@endif
        @else
            Tidak ada komentar!
        @endif
    </small>
</p>
<hr>
@if($dataevent->getCommentCount() > 2 && (empty($comment_count) || $comment_count < 3))
    <a class="btn btn-link btn-block btn-xs" href="{{ url('/post/'.$dataevent->id) }}"><i class="fa fa-bars" aria-hidden="true"></i> Tampilkan semua komentar</a>
@endif