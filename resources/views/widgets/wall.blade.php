<div class="clearfix"></div>
@if($user->id == Auth::user()->id)
<div class="new-post-box">
    <div class="well well-sm well-social-post" style="border-top:solid 4px #e8b563;">
        <form id="form-new-post" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="group_id" value="{{ $wall['new_post_group_id'] }}">
            <div class="panel-heading" style="border-bottom: solid 1px #ddd;border-radius: 0;background-color: #fff;">Update Status</div>
            <textarea class="form-control text-post" name="content" placeholder="What's in your mind?" style="resize:none;"></textarea>
            <div class="image-area">
                <a href="javascript:;" class="image-remove-button" onclick="removePostImage()"><i class="fa fa-times-circle"></i></a>
                <img src="" />
            </div>

                        <p><output id="listimage"></output></p>
                        <p><output id="list"></output></p>
            <div class="row row-res" style="padding: 10px;">
                    <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImage()" style="margin-left: 15px;">
                        <i class="fa fa-image"></i> Add Image
                    </button>
                    <input type="file" id="uploadimage" accept="image/*" multiple class="image-input" name="photo[]" onchange="previewPostImage(this)">
                    <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostFile()">
                        <i class="glyphicon glyphicon-file"></i> Add File
                    </button>
                    <input type="file" class="file-input" id="uploadfile" multiple name="file[]" onchange="previewPostFile(this)">
                    <div class="loading-post">
                        <img src="{{ asset('images/rolling.gif') }}" alt="">
                    </div>
                    <button type="button" class="btn btn-warning btn-submit pull-right" onclick="newPost()" style="margin-right: 15px;">
                        Post!
                    </button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="post-list-top-loading">
    <img src="{{ asset('images/rolling.gif') }}" alt="">
</div>
<div class="post-list">

</div>
<div class="post-list-bottom-loading">
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