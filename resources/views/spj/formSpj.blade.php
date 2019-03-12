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
    <div class="col-xs-12 col-md-3 pull-right" style="padding-right: 0;">
      <div class="hidden-sm hidden-xs">
        @include('news.widgets.news')
        @include('widgets.suggested_people')
      </div>
    </div>
    <div class="col-md-6 col-md-offset-3 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
         <h3 style="margin:0;">Form Permintaan SPJ</h3>
         <hr>
         <form action="javascript:void(0);" id="formspj" method="post" accept-charset="utf-8">
          <div class="form-group">
            <label for="inputevent">Nama Rapat</label>
            <input type="text" name="nama_rapat" class="form-control" placeholder="Nama Rapat" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="keterangan">Tanggal Rapat</label>
            <input type="date" class="form-control" name="tgl_rapat">
          </div>
          <label for="keterangan">Snack</label>
          <div class="form-group input-group">
            <input type="number" class="form-control" id="snack" onkeyup="jumlahharga()" name="snack" autocomplete="off">
            <span class="input-group-addon">BOX</span>
          </div>
          <label for="keterangan">Makan Siang</label>
          <div class="form-group input-group">
            <input type="number" class="form-control" id="makan" onkeyup="jumlahharga()" name="makan" autocomplete="off">
            <span class="input-group-addon">BOX</span>
          </div>
          <div class="form-group">
            <label for="keterangan">Total</label>
            <input type="number" class="form-control" name="total" id="total" autocomplete="off" readonly>
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
@endsection