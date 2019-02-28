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
<link href="https://rawgithub.com/hayageek/jquery-upload-file/master/css/uploadfile.css" rel="stylesheet">
<div class="h-20 res-post"></div>
<div class="col-md-12 res-home">
    <div class="row">
        <div class="col-md-3" style="padding-left: 0;position: fixed;width: 20%;">
            @include('widgets.sidebar')
        </div>
        <div class="col-xs-12 col-md-3 pull-right" style="padding-right: 0;">
            <div class="hidden-sm hidden-xs">
                @include('news.widgets.news')
                @include('widgets.suggested_people')
            </div>
        </div>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                   <h3 style="margin:0;">Form Verifikasi SPJ</h3>
                   <hr>
                   <form action="javascript:void(0);" id="formspj" method="post" accept-charset="utf-8">
                        <div class="form-group">
                            <label for="inputevent">Input Data Pemesanan</label>
                            <input type="text" name="data_pesanan" class="form-control" placeholder="Input data pemesanan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Snack</label>
                            <input type="number" class="form-control" id="snack" onkeyup="jumlahharga()" name="snack" autocomplete="off">
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
                            <label for="keterangan">Makan Siang</label>
                            <input type="number" class="form-control" id="makan" onkeyup="jumlahharga()" name="makan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="inputevent">Penyedia</label>
                            <input type="text" name="penyedia_makan" class="form-control" placeholder="Penyedia Makan" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Tanggal Kwintansi</label>
                            <input type="date" class="form-control" name="tgl_kw_makan">
                        </div>
                        <div id="mulitplefileuploader">Upload</div>
                        <div id="status"></div>
                        <hr>
                        <div class="form-group">
                            <label for="keterangan">Total</label>
                            <input type="number" class="form-control" name="total" id="total" autocomplete="off">
                            <input type="hidden" value="" id="booking" readonly class="form-control" name="status" >
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
<script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script>
<script type="text/javascript">
  WALL_ACTIVE = true;
  fetchPost(0,0,0,10,-1,-1,'initialize');
</script>
<script type="text/javascript">
  $(document).ready( function () {
    $('#table_pengguna').DataTable();
} );
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script>
  var extraObj = $("#mulitplefileuploader").uploadFile(
  {
    url: "upload.php",
  method: "POST",
  allowedTypes:"jpg,png,gif,doc,pdf,zip",
  fileName: "myfile",
  multiple: true,
  dragdropWidth:600,
    autoSubmit:false
    
  });
  
  $("#startbutton").click(function()
  {
    extraObj.startUpload();
    
  });

</script>
@endsection