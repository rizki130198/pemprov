@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">


            <div class="content-page-title">
                {{ $group->nama_grup }}
            </div>





            <div class="row">
                <div class="col-xs-12 col-md-3 pull-right">
                    <div class="hidden-sm hidden-xs">
                        @include('groups.widgets.people_in')
                    </div>
                </div>
                <div class="col-md-9"> 
                    @if($user->id == Auth::user()->id)
                    <div class="new-postgrup-box">
                        <div class="well well-sm well-social-postgrup" style="border-top:solid 4px #e8b563;">
                            <form id="form-new-postgrup">
                                <input type="hidden" name="group_id" value="{{ $wall['new_postgrup_group_id'] }}">
                                <div class="panel-heading" style="border-bottom: solid 1px #ddd;border-radius: 0;background-color: #fff;">Update Status</div>
                                <textarea class="form-control text-postgrup" name="content" placeholder="What's in your mind?" style="resize:none;"></textarea>
                                <div class="image-area">
                                    <a href="javascript:;" class="image-remove-button" onclick="removePostgrupImage()"><i class="fa fa-times-circle"></i></a>
                                    <img src="" />
                                </div>
                                <div class="row" style="padding: 10px;">
                                    <div class="col-xs-4">
                                        <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostgrupImage()">
                                            <i class="fa fa-image"></i> Add Image
                                        </button>
                                        <input type="file" accept="image/*" class="image-input" name="photo" onchange="previewPostgrupImage(this)">
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="loading-postgrup">
                                            <img src="{{ asset('images/rolling.gif') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="button" class="btn btn-warning btn-submit pull-right" onclick="newPostgrup()">
                                            Postgrup!
                                        </button>
                                    </div>
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
    </div>
</div>



@endsection

@section('footer')
<script type="text/javascript">
    WALL_ACTIVE = true;
    fetchPostgrup(2,0,{{ $group->id_grup }},10,-1,-1,'initialize');
</script>
@endsection