@extends('layouts.app')

@section('content')
<style type="text/css">
    .col-md-offset-3{
        margin-left: 21%;
    }
    @media(min-width: 1200px){
        .col-md-6{
            width: 53%;
        }
    }
    @media(max-width: 768px){
        .col-md-offset-3{
            margin-left: auto;
        }
    }
</style>
<div class="h-20 res-post"></div>
<div class="col-md-12 res-home">
    <div class="row">
        <div class="col-md-3" style="padding-left: 0;position: fixed;width: 20%;">
            @include('widgets.sidebar')
        </div>
        <div class="col-xs-12 col-md-3 pull-right" style="padding-right: 0;">
            <div class="hidden-sm hidden-xs">
                @include('widgets.suggested_people')
            </div>
        </div>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            @include('news.widgets.wall')
        </div>
    </div>
</div>    
@endsection

@section('footer')
<script type="text/javascript" src="//nightly.ckeditor.com/17-08-18-06-04/full/ckeditor.js"></script>
<script>
	CKEDITOR.replace('isi');
</script>
@endsection