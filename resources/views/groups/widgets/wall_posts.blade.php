@php($i = 0)
@php($post_max_id = 0)
@php($post_min_id = 0)
@foreach($posts as $post)
    @if($i == 0)
        @php($post_max_id = $post->id_post_grup)
    @endif
    @php($post_min_id = $post->id_post_grup)

    @include('groups.widgets.post_detail.single_post')

    @php($i++)
@endforeach
@foreach($div_location as $location) 
    <div class="postgrup_data_filter_{{ $location }}">
        <input type="hidden" name="wall_type" value="{{ $wall_type }}" />
        <input type="hidden" name="list_type" value="{{ $list_type }}" />
        <input type="hidden" name="optional_id" value="{{ $optional_id }}" />
        <input type="hidden" name="limit" value="{{ $limit }}" />
        <input type="hidden" name="postgrup_max_id" value="{{ $post_max_id }}" />
        <input type="hidden" name="postgrup_min_id" value="{{ $post_min_id }}" />
    </div>
@endforeach