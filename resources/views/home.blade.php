@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="col-md-12">
    <div class="row"> 
        <div class="col-sm-3" style="padding-left: 0;position: fixed;">
            @include('widgets.sidebar')
        </div>
        <div class="col-xs-12 col-md-3 pull-right">
            <div class="hidden-sm hidden-xs">
                @include('widgets.suggested_people')
            </div>
        </div>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            @include('widgets.wall')
        </div>
    </div>
</div>    
@endsection

@section('footer')
<script type="text/javascript">
    WALL_ACTIVE = true;
    fetchPost(0,0,0,10,-1,-1,'initialize');
</script>
@endsection