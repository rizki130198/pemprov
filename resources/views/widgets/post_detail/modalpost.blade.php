<div class="modal fade" id="modalpost" tabindex="-1" role="dialog" aria-labelledby="modalpostLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalpostLabel">Edit Postingan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="new-post-box">
          <div class="well well-sm well-social-post">
            <form id="form-update-post" enctype="multipart/form-data">
              @foreach($editdata as $editpost)
            <textarea class="form-control text-post" name="content" placeholder="What's in your mind?" style="resize:none;">{{$editpost->content}}</textarea>
            <input type="hidden" value="{{$editpost->id}}" name="idpost">
            <output id="listimagemodal"></output>
            <output id="listfilemodal"></output>
            @foreach($imagedata as $dataimage)
            @if($dataimage->file_path != 0 AND $dataimage->file_path != NULL)

            <?php 
            $file = explode(',',$dataimage->file_path);  ?>
            @for($i = 0; $i < count($file); $i++)
            <output id="file-{{$i}}"><a href="javascript:;" onclick="removefilemodal({{$i}})"><i class="fa fa-times-circle"></i></a><strong class="label label-primary">{{$file[$i]}}</strong></output>
            <input type="hidden" id="inputfile{{$i}}" name="fileold[]" value="{{$file[$i]}}">
            @endfor
            @elseif($dataimage->image_path != 0 AND $dataimage->image_path != NULL)

            <?php 
            $apa = explode(',',$dataimage->image_path); ?>
            @for($i = 0; $i < count($apa); $i++)
            <output id="image-{{$i}}"><a href="javascript:;" onclick="removeimagemodal({{$i}})"><i class="fa fa-times-circle"></i></a><strong class="label label-primary">{{$apa[$i]}}</strong></output>
            <input type="hidden" id="inputimage{{$i}}" name="imageold[]" value="{{$apa[$i]}}">
            @endfor
            @endif
            @endforeach
            @endforeach
            <div class="row" style="padding: 10px;">
              <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImagemodal()" style="margin-left: 15px;">
                <i class="fa fa-image"></i> Tambah Foto
              </button>
              <input type="file" id="modalimage" accept="image/*" multiple class="image-input" name="photo[]" onchange="previewPostImagemodal(this)">
              <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostFilemodal()">
                <i class="glyphicon glyphicon-file"></i> Tambah File
              </button>
              <input type="file" class="typefile" id="filemodal" name="files[]" multiple onchange="previewPostFilemodal(this)">
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" onclick="updatePost()" class="btn btn-primary">Ubah Data</button>
      </div>
    </form>
  </div>
</div>
</div>
<script type="text/javascript">
  function removefilemodal(id) {
    $("#inputfile"+id).attr('disabled','disabled');
    $("#originfile"+id).attr('disabled','disabled');
    $("#file-"+id).hide();
  }
  function removeimagemodal(id) {
    $("#inputimage"+id).attr('disabled','disabled');
    $("#originname"+id).attr('disabled','disabled');
    $("#image-"+id).hide();
  }
  function uploadPostImagemodal(){
    var form_name = '#form-update-post';
    $('#listimagemodal').removeAttr('disabled');
    $('#modalimage').click();
  }
  function previewPostImagemodal(input){

    var output = [];
    for (var i = 0, f; f = input.files[i]; i++) {
      output.push('<li><strong class="label label-primary"><a href="javascript:;" class="fa fa-times-circle" onclick="removeupdateImage()"><i class="fa fa-times-circle"></i></a>', escape(f.name), '</strong>',
        '</li>');
    }
    document.getElementById('listimagemodal').innerHTML = '<ul>' + output.join('') + '</ul>';
    $('#listfilemodal').html('');
  }

  function removePostFile(){
    var form_name = '#form-update-post';
    $('#listfilemodal').html('');
    $('#listfilemodal').attr('disabled','disabled');
    resetFile($(form_name + ' .typefile'));
    resetFile($('#listfilemodal'));
  }
  function uploadPostFilemodal(){
    var form_name = '#form-update-post';
    $('#listfilemodal').removeAttr('disabled');
    $('#filemodal').click();
  }

  function previewPostFilemodal(input){
    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = input.files[i]; i++) {
      output.push('<li><strong class="label label-primary"><a href="javascript:;" class="fa fa-times-circle" onclick="removeupdateImage()"><i class="fa fa-times-circle"></i></a>', escape(f.name), '</strong>',
        '</li>');
    }
    document.getElementById('listfilemodal').innerHTML = '<ul>' + output.join('') + '</ul>';
    $('#listimagemodal').html('');
  }

  function removeupdateImage(){
    var form_name = '#form-update-post';
    $('#listimagemodal').html('');
    $('#listimagemodal').attr('disabled','disabled');
    resetFile($(form_name + ' .image-input'));
    resetFile($('#listimagemodal'));
  }

  function cleanupdatePostForm(){
    var form_name = '#form-update-post';
    $(form_name + ' textarea').val('');
    $('#listfilemodal').html('');
    $('#listimagemodal').html('');
    removeupdateImage();
    removePostFile();
  }
  function updatePost(){
    var form_name = '#form-update-post';

    var data = new FormData();
    data.append('data', JSON.stringify(makeSerializable(form_name).serializeJSON()));

    var ins = document.getElementById('modalimage').files.length;
    for (var x = 0; x < ins; x++) {
      data.append("image[]", document.getElementById('modalimage').files[x]);
    }

    var ini = document.getElementById('filemodal').files.length;
    for (var x = 0; x < ini; x++) {
      data.append("filemodal[]", document.getElementById('filemodal').files[x]);
    }

    <?php foreach($imagedata as $dataimage){
      $file = explode(',',$dataimage->file_path); 
      $apa = explode(',',$dataimage->image_path); ?>
      for (var x = 0; x < <?= count($file) ?>; x++) {
        data.append("fileold[]", document.getElementById('inputfile'+[x]));
        console.log('inputfile'+[x]);
      }

      for (var x = 0; x < <?= count($apa) ?>; x++) {
        data.append("imageold[]", document.getElementById('inputimage'+[x]));
        console.log('inputimage'+[x]);
      }
    <?php }?>

    $.ajax({
      url: BASE_URL+'/post/update',
      type: "POST",
      timeout: 5000,
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      headers: {'X-CSRF-TOKEN': CSRF},
      success: function(response){
        if (response.code == 200){
          cleanupdatePostForm()
          location.reload();
        }else{
          $('#errorMessageModal').modal('show');
          $('#errorMessageModal #errors').html(response.message);
        }
      },
      error: function(){
        $('#errorMessageModal').modal('show');
        $('#errorMessageModal #errors').html('Something went wrong!');
      }
    });

  }
</script>