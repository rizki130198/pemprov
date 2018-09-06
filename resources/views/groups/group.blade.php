@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<style type="text/css">
.nav-tabs{
    display: none;
}
@media(max-width: 768px){
    .row-group{
        margin-left: 0;
        margin-right: 0;
    }
    .row-group .col-md-6{
        padding-right: 0;
        padding-left: 0;
    }
    .col-group{
        padding-left: 0;
        padding-right: 0;
    }
    .nav-tabs { 
        border-bottom: 2px solid #DDD; 
        white-space: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        height: 55px;
        margin-bottom: 23px;
        background-color: #fff;
        display: block !important;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover { 
        border-width: 0;
        font-weight: bold;
    }
    .nav-tabs > li > a { 
        border: none; 
        font-size: 16px;
        font-weight: normal;
        font-style: normal;
        font-stretch: normal;
        line-height: 0.75;
        letter-spacing: normal;
        float: left !important;
        color: #3d464d; 
        text-transform: uppercase;
        margin-right: 27px;
        padding: 20px 0px !important;
    }
    .nav-tabs > li.active > a, .nav-tabs > li > a:hover { 
        border: none; background: transparent; 
    }
    .nav-tabs > li > a::after { 
        content: ""; 
        background: #d5483c; 
        height: 3px; 
        position: absolute; 
        width: 100% !important;
        left: 0px !important;
        bottom: -1px; 
        transition: all 250ms ease 0s; 
        transform: scale(0); 
    }
    .nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after { transform: scale(1); }

    .nav-tabs > li {
        float: none;
        display: inline-block;
        left: 17px;
    }
    .profile{
        margin-bottom: 0 !important;
    }
    /*.profile-text h4{
        font-size: 20px !important;
        }*/
    }
</style>
<div class="col-md-12 col-group">
    <div class="row row-group">
        <div class="col-md-3" style="padding-left: 0;position: fixed;">
            @include('widgets.sidebar')
        </div>
        <div class="col-xs-12 col-md-3 pull-right" style="padding-right: 0;">
            <div class="hidden-sm hidden-xs">
                @include('groups.widgets.people_in')
            </div>

        </div>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="profile" style="margin-bottom: 20px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="cover @if($group->cover_grup == ''){{ 'no-cover' }}@endif" style="">
                            <div class="loading-cover">
                                <img src="{{ asset('images/rolling.gif') }}" alt="">
                            </div>
                            <div class="bar" style="padding: 10px 20px;">
                                <div class="" style="position: relative;height: 100%;">
                                    <div class="profile-text" style="left: 0;">
                                        <h4>{{ $group->nama_grup }}</h4>
                                    </div>
                                    <form id="form-upload-cover" enctype="multipart/form-data">
                                        <div class="profile-upload-cover">
                                            <a href="javascript:;" class="btn btn-info upload-button" onclick="uploadGroupCover()"><i class="fa fa-upload"></i> Change Cover</a>
                                            <input type="file" accept="image/*" name="cover" class="cover_input">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">DISKUSI</a></li>
                <li><a href="#">ANGGOTA</a></li>
                <li><a href="#">FOTO GRUP</a></li>
                <li><a href="#">PENGATURAN GRUP</a></li>
            </ul>
            @if (Request::segment(2) == 'diskusi')
            @if($user->id == Auth::user()->id)
            <div class="new-postgrup-box">
                <div class="well well-sm well-social-post" style="border-top:solid 4px #e8b563;">
                    <form method="post" id="form-new-postgrup" enctype="multipart/form-data" accept-charset="utf-8">
                        <input type="hidden" name="group_id" value="{{ $id_link }}">
                        <div class="panel-heading" style="border-bottom: solid 1px #ddd;border-radius: 0;background-color: #fff;">Update Status</div>
                        <textarea class="form-control text-post" name="content" placeholder="What's in your mind?" style="resize:none;"></textarea>
                        <div class="image-area">
                            <a href="javascript:;" class="image-remove-button" onclick="removePostgrupImage()"><i class="fa fa-times-circle"></i></a>
                            <img src="" />

                        </div>
                        <p><output id="list"></output></p>
                        <div class="row" style="padding: 10px;">
                            <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostgrupImage()" style="margin-left: 15px;">
                                <i class="fa fa-image"></i> Add Image
                            </button>
                            <input type="file" id="imageupload" accept="image/*" multiple class="image-input" name="photo" onchange="previewPostgrupImage(this)">
                            <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostgrupFile()">
                                <i class="glyphicon glyphicon-file"></i> Add File
                            </button>
                            <input type="file" multiple class="file-input" id="file" name="file" onchange="previewPostgrupFile(this)">
                            <div class="loading-postgrup">
                                <img src="{{ asset('images/rolling.gif') }}" alt="">
                            </div>
                            <button type="button" class="btn btn-warning btn-submit pull-right" onclick="newPostgrup()" style="margin-right: 15px;">
                                Post!
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <div class="postgrup-list-top-loading">
                <img src="{{ asset('images/rolling.gif') }}" alt="">
            </div>
            <div class="postgrup-list">

            </div>
            <div class="postgrup-list-bottom-loading">
                <img src="{{ asset('images/rolling.gif') }}" alt="">
            </div>
            @elseif (Request::segment(2) == 'anggota')

                @include('groups.widgets.anggota')
            
            @elseif (Request::segment(2) == 'foto')

                @include('groups.widgets.foto')

            @endif
            <div class="modal fade " id="likeListModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title">Likes</h5>
                        </div>

                        <div class="user_list">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script type="text/javascript">
    function uploadGroupCover(){
        var div_name = '.cover';
        var form_name = '#form-upload-cover';
        $(form_name+' input').click();
        $(form_name+' input').change(function (){

            $(div_name+ ' .loading-cover').show();

            var data = new FormData();
            data.append('cover', JSON.stringify(makeSerializable(form_name).serializeJSON()));


            var file_inputs = document.querySelectorAll('.cover_input');
            $(file_inputs).each(function(index, input) {
                data.append('image', input.files[0]);
            });


            $.ajax({
                url: REQUEST_URL+'/upload/cover_grup',
                type: "POST",
                timeout: 5000,
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': CSRF},
                success: function(response){
                    if (response.code == 200){
                        $(div_name).css('background-image', 'url('+response.image+')');
                        $(div_name+ ' .loading-cover').hide();
                        $(div_name).removeClass('no-cover');
                    }else{
                        $('#errorMessageModal').modal('show');
                        $('#errorMessageModal #errors').html(response.message);
                        $(div_name+ ' .loading-cover').hide();
                    }
                },
                error: function(){
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html('Something went wrong!');
                    $(div_name+ ' .loading-cover').hide();
                }
            });
        });
    }

    WALL_ACTIVE = true;
    fetchPostgrup(0,0,{{ $group->id_grup }},10,-1,-1,'initialize');
</script>
<script type="text/javascript">
    (function() {
        var toggleElement;
        toggleElement = function($el, type) {
            if (type != null) {
                if (type === 'open') {
                    $el.addClass('panel-element-open');
                    $el.siblings('.panel-element').removeClass('panel-element-open');
                } else if (type === 'close') {
                    $el.removeClass('panel-element-open');
                }
            } else {
                if ($el.hasClass('panel-element-open')) {
                    toggleElement($el, 'close');
                } else {
                    toggleElement($el, 'open');
                }
            }
            return null;
        };

        $(document).ready(function() {
            var hammertime;
            $('.btn').click(function() {
                var $parent;
                $parent = $(this).parents('.panel-element');
                if ($(this).hasClass('btn-more')) {
                    if (!hammertime) {
                        return toggleElement($parent);
                    }
                }
            });
        });
    }).call(this);
</script>
@endsection