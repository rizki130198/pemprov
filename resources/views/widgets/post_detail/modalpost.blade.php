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
            '</li>
            <textarea class="form-control text-post" name="content" placeholder="What's in your mind?" style="resize:none;">{{$editpost->content}}</textarea>
            <output id="listimagemodal"></output>
            <output id="listfilemodal"></output>
            @if($editpost->image_path == NULL)
            <?php $file = explode(',',$editpost->file_path); ?>
            @for($i = 0; $i < count($file); $i++)
            <a href="javascript:;" onclick="removefilemodal()"><i class="fa fa-times-circle"></i></a>
            <output id="lista-{{$editpost->id_post_grup}}"><strong class="label label-primary">{{$file[$i]}}</strong></output>
            <input type="hidden" name="fileold[]" value="{{$file[$i]}}">
            @endfor
            @else
            <?php $apa = explode(',',$editpost->image_path); ?>
            @for($i = 0; $i < count($editpost); $i++)
            <a href="javascript:;" onclick="removeimagemodal()"><i class="fa fa-times-circle"></i></a>
            <output id="file-{{$editpost->id_post_grup}}"><strong class="label label-primary">{{$apa[$i]}}</strong></output>
            <input type="hidden" name="imageold[]" value="{{$apa[$i]}}">
            @endfor
            @endif

            <div class="row" style="padding: 10px;">
              <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImagemodal()" style="margin-left: 15px;">
                <i class="fa fa-image"></i> Tambah Foto
              </button>
              <input type="file" id="imageupload" accept="image/*" multiple class="image-input" name="photo[]" onchange="previewPostImagemodal(this)">
              <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImagemodal()">
                <i class="glyphicon glyphicon-file"></i> Tambah File
              </button>
              <input type="file"  class="file-input" id="files" name="files[]" multiple onchange="previewPostImagemodal(this)">
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