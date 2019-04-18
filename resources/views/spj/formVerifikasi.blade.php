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
.modal-dialog {
  position:absolute;
  top:50% !important;
  transform: translate(0, -50%) !important;
  -ms-transform: translate(0, -50%) !important;
  -webkit-transform: translate(0, -50%) !important;
  margin:auto 35%;
  width:25%;
  height:35%;
}
.modal-content {
  min-height:100%;
  position:absolute;
  top:0;
  bottom:0;
  left:0;
  right:0; 
}
.modal-footer {
  position:absolute;
  bottom:0;
  left:0;
  right:0;
}
input[type="checkbox"].switch_1{
  font-size: 18px;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: 2.7em;
  height: 1.5em;
  background: #ddd;
  border-radius: 3em;
  position: relative;
  cursor: pointer;
  outline: none;
  -webkit-transition: all .2s ease-in-out;
  transition: all .2s ease-in-out;
}

input[type="checkbox"].switch_1:checked{
  background: #42a5f5;
}

input[type="checkbox"].switch_1:after{
  position: absolute;
  content: "";
  width: 1.5em;
  height: 1.5em;
  border-radius: 50%;
  background: #fff;
  -webkit-box-shadow: 0 0 .25em rgba(0,0,0,.3);
  box-shadow: 0 0 .25em rgba(0,0,0,.3);
  -webkit-transform: scale(.7);
  transform: scale(.7);
  left: 0;
  -webkit-transition: all .2s ease-in-out;
  transition: all .2s ease-in-out;
}

input[type="checkbox"].switch_1:checked:after{
  left: calc(100% - 1.5em);
}
</style>
<div class="h-20 res-post"></div>
<div class="col-md-12 res-home">
  <div class="row">
    <div class="col-md-3" style="padding-left: 0;position: fixed;width: 20%;">
      @include('widgets.sidebar')
    </div>
    <!-- <div class="col-xs-12 col-md-3 pull-right" style="padding-right: 0;">
      <div class="hidden-sm hidden-xs">
        @include('news.widgets.news')
        @include('widgets.suggested_people')
      </div>
    </div> -->
    <div class="col-md-8 col-md-offset-3 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
         <h3 style="margin:0;">Form Verifikasi SPJ</h3>
         <hr>
         <form action="javascript:void(0);" id="formverif" method="post" accept-charset="utf-8" enctype="multipart/form-data" >
          <div class="form-group">
            <input type="hidden" name="id_form" value="{{$verif->id_pengajuan}}">
            <label for="keterangan">Harga Total Snack</label>
            <input type="number" class="form-control" id="snack" onkeyup="hargastock()" name="snack" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="inputevent">Penyedia</label>
            <input type="text" name="penyedia_snack" class="form-control" placeholder="Penyedia Snack" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="keterangan">Tanggal Kwintansi</label>
            <input type="date" class="form-control" name="tgl_kw_snack">
          </div>
          <hr>
          <div class="form-group">
            <label for="keterangan">Harga Total Makan Siang</label>
            <input type="number" class="form-control" id="makan" name="makan" onkeyup="hargastock()" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="inputevent">Penyedia</label>
            <input type="text" name="penyedia_makan" class="form-control" placeholder="Penyedia Makan" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="keterangan">Tanggal Kwintansi</label>
            <input type="date" class="form-control" name="tgl_kw_makan">
          </div>
          <label>Foto Kwitansi</label>
          <div class="controls-kwitansi">
            <div class="forms-kwitansi row">
              <div class="entry-kwitansi">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-5">
                      <div class="well" style="padding: 5px;">
                        <input type="file" name="myfile[]" multiple>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-more-kwitansi">Tambah</button>
                      </span>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label for="keterangan">Total</label>
            <input type="number" class="form-control" name="total" id="total" autocomplete="off" readonly>
          </div>
          <button type="submit" class="btn btn-primary pull-right">Kirim</button>
        </form>
      </div>
    </div>          
  </div>
</div>
</div>    
@endsection

@section('footer')
<script type="text/javascript">
  WALL_ACTIVE = true;
  fetchPost(0,0,0,10,-1,-1,'initialize');
</script>
<script type="text/javascript">
 $(document).on('click', '.add-more-kwitansi', function(e){
  e.preventDefault();

  var controlForm = $('.controls-kwitansi .forms-kwitansi:first'),
  currentEntry = $(this).parents('.entry-kwitansi:first'),
  newEntry = $(currentEntry.clone()).appendTo(controlForm);

  newEntry.find('input').val('');
  controlForm.find('.entry-kwitansi:not(:last) .add-more-kwitansi')
  .removeClass('add-more-kwitansi').addClass('btn-remove')
  .removeClass('btn-info').addClass('btn-danger')
  .html('Hapus');
}).on('click', '.btn-remove', function(e){
  $(this).parents('.entry-kwitansi:first').remove();

  e.preventDefault();
  return false;
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection