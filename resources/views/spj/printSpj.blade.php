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
.table-print tr td{
  font-size: 30px;
}
</style>
<div class="h-20 res-post"></div>
<div class="col-md-12 res-home">
  <div class="panel">
    <div class="panel-body" style="padding-top: 0;">
      <h1 style="text-transform: uppercase;line-height: 1.5;text-align: center;margin-bottom:35px; ">Pengajuan SPJ <br>
      Dinas Cipta Karya Tata Ruang & pertahanan<br>
      provinsi dki jakarta<br>
      tahun anggaran <?php echo date("Y");?></h1>
      <hr>
      <table style="margin:5% 3%;" class="table-print">
        @foreach($selesai as $data)
        <tr>
          <td>No. Pengajuan </td> 
          <td style="padding: 20px;"> :</td>
          <td>{{$data->id_pengajuan}}-{{date('Y')}}</td>
        </tr>
        <tr>
          <td>Nama </td> 
          <td style="padding: 20px;"> :</td>
          <td>{{$data->name}}</td>
        </tr>
        <tr>
          <td>Bidaq </td>
          <td style="padding: 20px;"> :</td>
          <td>Tata Ruang</td>
        </tr>
        <tr>
          <td>Total Pengajuan </td>
          <td style="padding: 20px;"> :</td>
          <td>{{"Rp " . number_format($data->total,2,',','.')}}</td>
        </tr>
        <tr>
          <td>Nama Rapat </td>
          <td style="padding: 20px;"> :</td>
          <td>{{$data->nama_rapat}}</td>
        </tr>
        <tr>
          <td>Rapat Tanggal </td>
          <td style="padding: 20px;"> :</td>
          <td>{{$data->tanggal_rapat}}</td>
        </tr>
        @endforeach
      </table>
      <hr>
      <h4>dcktrp.jakarta.co.id/spj/</h4>
    </div>
  </div>          
</div>  

<script type="text/javascript">
  WALL_ACTIVE = true;
  fetchPost(0,0,0,10,-1,-1,'initialize');
</script>
<script type="text/javascript">
  window.onload = function() { window.print(); }
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