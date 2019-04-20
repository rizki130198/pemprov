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
            <input class="form-control" name="tgl_kw_snack" id="tgl_kw_snack">
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
            <input class="form-control" name="tgl_kw_makan" id="tgl_kw_makan">
          </div>
          <div class="row">
            <div class="col-md-5">
              <label>Foto Kwitansi</label>
              <div class="controls-kwitansi">
                <div class="forms-kwitansi row">
                  <div class="entry-kwitansi">
                    <div class="col-md-10">
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
            <div class="col-md-5" style="padding-left: 70px;">
              <label>Foto Kwitansi Dinas</label>
              <div class="controls-kwd">
                <div class="forms-kwd row">
                  <div class="entry-kwd">
                    <div class="col-md-10">
                      <div class="well" style="padding: 5px;">
                        <input type="file" name="myfile_kwd[]" multiple>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-more-kwd">Tambah</button>
                      </span>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <label>Foto Absensi</label>
              <div class="controls-absensi">
                <div class="forms-absensi row">
                  <div class="entry-absensi">
                    <div class="col-md-10">
                      <div class="well" style="padding: 5px;">
                        <input type="file" name="ft_absen[]" multiple>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-more-absensi">Tambah</button>
                      </span>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5" style="padding-left: 70px;">
              <label>Foto Notulen</label>
              <div class="controls-notulen">
                <div class="forms-notulen row">
                  <div class="entry-notulen">
                    <div class="col-md-10">
                      <div class="well" style="padding: 5px;">
                        <input type="file" name="ft_notulen[]" multiple>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-more-notulen">Tambah</button>
                      </span>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>  
          <div class="row">
            <div class="col-md-5">
              <label>Foto Undangan</label>
              <div class="controls-undangan">
                <div class="forms-undangan row">
                  <div class="entry-undangan">
                    <div class="col-md-10">
                      <div class="well" style="padding: 5px;">
                        <input type="file" name="ft_undangan[]" multiple>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-more-undangan">Tambah</button>
                      </span>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5" style="padding-left: 70px;">
              <label>Foto Nota</label>
              <div class="controls-nota">
                <div class="forms-nota row">
                  <div class="entry-nota">
                    <div class="col-md-10">
                      <div class="well" style="padding: 5px;">
                        <input type="file" name="ft_nota[]" multiple>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-more-nota">Tambah</button>
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
<script src="{{ asset('js/spj.js') }}"></script>
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
//kwitansi dinas
$(document).on('click', '.add-more-kwd', function(e){
  e.preventDefault();

  var controlForm = $('.controls-kwd .forms-kwd:first'),
  currentEntry = $(this).parents('.entry-kwd:first'),
  newEntry = $(currentEntry.clone()).appendTo(controlForm);

  newEntry.find('input').val('');
  controlForm.find('.entry-kwd:not(:last) .add-more-kwd')
  .removeClass('add-more-kwd').addClass('btn-remove')
  .removeClass('btn-info').addClass('btn-danger')
  .html('Hapus');
}).on('click', '.btn-remove', function(e){
  $(this).parents('.entry-kwd:first').remove();

  e.preventDefault();
  return false;
});
//absensi
$(document).on('click', '.add-more-absensi', function(e){
  e.preventDefault();

  var controlForm = $('.controls-absensi .forms-absensi:first'),
  currentEntry = $(this).parents('.entry-absensi:first'),
  newEntry = $(currentEntry.clone()).appendTo(controlForm);

  newEntry.find('input').val('');
  controlForm.find('.entry-absensi:not(:last) .add-more-absensi')
  .removeClass('add-more-absensi').addClass('btn-remove')
  .removeClass('btn-info').addClass('btn-danger')
  .html('Hapus');
}).on('click', '.btn-remove', function(e){
  $(this).parents('.entry-absensi:first').remove();

  e.preventDefault();
  return false;
});
//notulen
$(document).on('click', '.add-more-notulen', function(e){
  e.preventDefault();

  var controlForm = $('.controls-notulen .forms-notulen:first'),
  currentEntry = $(this).parents('.entry-notulen:first'),
  newEntry = $(currentEntry.clone()).appendTo(controlForm);

  newEntry.find('input').val('');
  controlForm.find('.entry-notulen:not(:last) .add-more-notulen')
  .removeClass('add-more-notulen').addClass('btn-remove')
  .removeClass('btn-info').addClass('btn-danger')
  .html('Hapus');
}).on('click', '.btn-remove', function(e){
  $(this).parents('.entry-notulen:first').remove();

  e.preventDefault();
  return false;
});
//undangan
$(document).on('click', '.add-more-undangan', function(e){
  e.preventDefault();

  var controlForm = $('.controls-undangan .forms-undangan:first'),
  currentEntry = $(this).parents('.entry-undangan:first'),
  newEntry = $(currentEntry.clone()).appendTo(controlForm);

  newEntry.find('input').val('');
  controlForm.find('.entry-undangan:not(:last) .add-more-undangan')
  .removeClass('add-more-undangan').addClass('btn-remove')
  .removeClass('btn-info').addClass('btn-danger')
  .html('Hapus');
}).on('click', '.btn-remove', function(e){
  $(this).parents('.entry-undangan:first').remove();

  e.preventDefault();
  return false;
});
//nota
$(document).on('click', '.add-more-nota', function(e){
  e.preventDefault();

  var controlForm = $('.controls-nota .forms-nota:first'),
  currentEntry = $(this).parents('.entry-nota:first'),
  newEntry = $(currentEntry.clone()).appendTo(controlForm);

  newEntry.find('input').val('');
  controlForm.find('.entry-nota:not(:last) .add-more-nota')
  .removeClass('add-more-nota').addClass('btn-remove')
  .removeClass('btn-info').addClass('btn-danger')
  .html('Hapus');
}).on('click', '.btn-remove', function(e){
  $(this).parents('.entry-nota:first').remove();

  e.preventDefault();
  return false;
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script>
  $(document).ready(function () {
    $('#tgl_kw_snack').datepicker({
      uiLibrary: 'bootstrap'
    });
  });
  $(document).ready(function () {
    $('#tgl_kw_makan').datepicker({
      uiLibrary: 'bootstrap'
    });
  });
</script>
@endsection