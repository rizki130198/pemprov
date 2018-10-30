<div class="modal fade" id="modalpostgrup" tabindex="-1" role="dialog" aria-labelledby="modalpostgrupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalpostgrupLabel">Edit Postingan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="new-post-box">
          <div class="well well-sm well-social-post">
            <form id="form-update-post">
              @foreach($editdata as $editpost)

              <textarea class="form-control text-post" name="content" placeholder="What's in your mind?" style="resize:none;">{{$editpost->content}}</textarea>
              <div class="row" style="padding: 10px;">
                <div class="col-xs-2">
                  <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImagemodal()">
                    <i class="fa fa-image"></i> Add Image
                  </button>
                  <input type="file" accept="image/*" class="image-input" name="photo" onchange="previewPostImagemodal(this)">
                </div>
                <div class="col-xs-2">
                  <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImagemodal()">
                    <i class="glyphicon glyphicon-file"></i> Add File
                  </button>
                  <input type="file" accept="image/*" class="image-input" name="photo" onchange="previewPostImagemodal(this)">
                </div>
              </div>
              @endforeach
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
      </div>
    </form>
  </div>
</div>
</div>