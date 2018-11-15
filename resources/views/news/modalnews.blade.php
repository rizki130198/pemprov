<div class="modal fade" id="modalpostnews" tabindex="-1" role="dialog" aria-labelledby="modalpostnewsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalpostnewsLabel">Edit News</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/news/update" id="form-news-update" method="post" enctype="multipart/form-data" accept-charset="utf-8">

          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="new-post-box">
            <div class="well well-sm well-social-post">
              @foreach($editdata as $editpost)
              <div class="panel-body">
                <p>Judul Berita</p>
                <input required style="min-height: auto;" type="text" value="{{$editpost->judul}}" name="judul" class="form-control" placeholder="Judul Berita">
              </div>
              <textarea class="form-control text-post" id="content" name="content" placeholder="What's in your mind?" style="resize:none;">{!! $editpost->isi !!}</textarea>
              <div class="image-area">
                <a href="javascript:;" class="image-remove-button" onclick="removenewsImagemodal()"><i class="fa fa-times-circle"></i></a>
                <img src="" />
              </div>
              <input type="hidden" value="{{$editpost->id}}" name="idnews">
              <output id="image-cover"><a href="javascript:;" onclick="removeimagemodal()"><i class="fa fa-times-circle"></i></a><strong class="label label-primary">{{$editpost->cover}}</strong></output>
              <input type="hidden" id="inputimage" name="imageold" value="{{$editpost->cover}}">

              @endforeach
              <div class="row" style="padding: 10px;">
                <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImagemodal()" style="margin-left: 15px;">
                  <i class="fa fa-image"></i> Tambah Foto
                </button>
                <input type="file" id="modalimage" accept="image/*" class="image-input" name="image" onchange="previewPostImagemodal(this)">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="SUBMIT" class="btn btn-primary">Ubah Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="//nightly.ckeditor.com/17-08-18-06-04/full/ckeditor.js"></script>
  <script type="text/javascript">

    CKEDITOR.replace('content');
    function removeimagemodal() {
      $("#inputimage").attr('disabled','disabled');
      $("#image-cover").hide();
    }
    function uploadPostImagemodal(){
      var form_name = '#form-news-update';
      $('#modalimage').click();
    }
    function previewPostImagemodal(input){

      var form_name = '#form-news-update';
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $(form_name + ' .image-area img').attr('src', e.target.result);
          $(form_name + ' .image-area').show();
        };

        reader.readAsDataURL(input.files[0]);
      }
    }

    function removeupdateImage(){
      var form_name = '#form-news-update';
      $('#listimagemodal').hide();
      resetFile($(form_name + ' .image-input'));
      resetFile($('#listimagemodal'));
    }
    function removenewsImagemodal(){
      var form_name = '#form-news-update';
      resetFile($(form_name + ' .image-input-news'));
    }

    function cleanupdatePostForm(){
      var form_name = '#form-news-update';
      $(form_name + ' textarea').val('');
      $('#listfilemodal').html('');
      $('#listimagemodal').html('');
      removeupdateImage();
      removePostFile();
    }
  </script>