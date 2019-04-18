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
.modal-dialog-ubah {
	position:absolute;
	top:50% !important;
	transform: translate(0, -50%) !important;
	-ms-transform: translate(0, -50%) !important;
	-webkit-transform: translate(0, -50%) !important;
	margin:auto 35%;
	width:30%;
	height:45%;
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
		<div class="col-md-3 col-md-offset-3 col-xs-12">
			<div class="panel panel-default panel-saldo">
				<a data-toggle="modal" data-target="#info">
					<button class="btn btn-default pull-right btn-xs" type="button" style="display: inline-block;float: right;border-radius: 20px;width: 40px;font-weight: bold;border:none;margin: 15px 15px 0 5px;">Info</button>
				</a>
				@if(Auth::user()->role == 'admin' OR Auth::user()->role == 'subbag')
				<a data-toggle="modal" data-target="#ubah">
					<button class="btn btn-warning pull-right btn-xs" type="button" style="display: inline-block;float: right;border-radius: 20px;width: 45px;font-weight: bold;border:none;margin: 15px 0;">Ubah</button>
				</a>
				@endif
				<a href="{{url('/spj/formSpj')}}">
					<div class="panel-body">
						<br>
						<h4 style="color: #fff;letter-spacing: 3px;font-weight: bold;">Biaya Anggaran</h4>
						<h5 style="color: #fff;">{{ "Rp " . number_format($total->saldo,2,',','.') }}</h5>
					</div>
				</a>
			</div>               
		</div>
        <div class="col-md-3 col-xs-12">
            <div class="panel panel-default panel-saldo" style="background: #FDC830;background: -webkit-linear-gradient(45deg, #F37335, #FDC830);background: linear-gradient(45deg, #F37335, #FDC830);">
                <a href="{{url('/spj/formSpj')}}">
                    <div class="panel-body">
                        <br>
                        <h4 style="color: #fff;letter-spacing: 3px;font-weight: bold;">Biaya Booking</h4>
                        <h5 style="color: #fff;">{{ "Rp " . number_format($total->saldo,2,',','.') }}</h5>
                    </div>
                </a>
            </div>
        </div>
        <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <form action="javascript:void(0);" id="grupcreate" method="post" accept-charset="utf-8">
                  <div class="modal-body">
                     <h4>Info Biaya Booking</h4>
                     <hr>
                     <table>
                        <tr>
                           <td>Pagu Snack </td> 
                           <td style="padding: 3px;"> :</td>
                           <td>{{"Rp " . number_format($saldo[0]->saldo,2,',','.')}}</td>
                       </tr>
                       <tr>
                           <td>Pagu Makan Siang </td> 
                           <td style="padding: 3px;"> :</td>
                           <td>{{"Rp " . number_format($saldo[1]->saldo,2,',','.')}}</td>
                       </tr>
                       <tr>
                           <td><label>Pagu Total </label></td>
                           <td style="padding: 3px;"> :</td>
                           <td>{{"Rp " . number_format($total->saldo,2,',','.')}}</td>
                       </tr>
                   </table>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
               </div>
           </form>
       </div>
   </div>
</div>
<div class="modal fade" id="ubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog-ubah" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h4>Info Biaya Anggaran</h4>
            <hr>
            <table class="table table-striped">
               <thead>
                  <tr>
                     <th>Pagu</th>
                     <th>Saldo</th>
                 </tr>
             </thead>
             <tbody>
                <tr>
                   <td>Snack</td>
                   <td class="table_data" data-row_id="{{$saldo[0]->id_saldo}}" data-column_name="saldo" contenteditable>{{$saldo[0]->saldo}}</td>
               </tr>
               <tr>
                   <td>Makan Siang</td>
                   <td class="table_data" data-row_id="{{$saldo[1]->id_saldo}}" data-column_name="saldo" contenteditable>{{$saldo[1]->saldo}}</td>
               </tr>
           </tbody>
       </table>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
  </div>
</div>
</div>
</div>
<div class="col-md-9 col-md-offset-3 col-xs-12 col-spj">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab">PENDING <span class="badge" style="background-color:#e74c3c;">2</span></a></li>
    <li role="presentation"><a href="#tolak" aria-controls="tolak" role="tab" data-toggle="tab">Tolak <span class="badge" style="background-color:#e74c3c;">2</span></a></a></li>
    <li role="presentation"><a href="#terima" aria-controls="terima" role="tab" data-toggle="tab">Selesai <span class="badge" style="background-color:#e74c3c;">2</span></a></a></li>
    <li style="display:none;float: right;font-size: 28px;padding-right: 10px;padding-top: 6px;color: #dedfe1;"><i class="fa fa-th-large"></i></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="pending">
     <div class="panel panel-default panel-spj">
      <div class="panel-body">
       <h3 style="margin:0;">List Permintaan SPJ <small>(Pending)</small></h3>
       <hr>
       <div class="table-responsive">
         <table id="table_pengguna" class="table table-striped table-no-bordered table-hover" style="width:100%">
          <thead>
           <tr>
            <th>No</th>
            <th>Nama</th>
            <th style="width: 100px;">Biaya</th>
            <th>Nama Rapat</th>
            <th>Tanggal Rapat</th>
            <th>Status</th>
            <th class="disabled-sorting">Actions</th>
          </tr>
        </thead>
        <tbody>
         @foreach($pending as $data)
         <tr>
          <td>{{$data->id_pengajuan}}-{{date('Y')}}</td>
          <td>{{$data->name}}</td>
          @if($data->total_fix == NULL)
          <td>{{"Rp " . number_format($data->total,2,',','.')}}</td>
          @else
          <td>{{"Rp " . number_format($data->total_fix,2,',','.')}}</td>
          @endif
          <td>{{$data->nama_rapat}}</td>
          <td>{{$data->tanggal_rapat}}</td>
          @if($data->status == 'Terima' AND Auth::user()->role == 'member')
          <td>Data Sedang di Verifikasi Subbag Keuangan</td>
          @elseif($data->status == 'Verifikasi' AND Auth::user()->role == 'member')
          <td>Data Sudah di Verifikasi PPTK</td>
          @elseif($data->status == 'Verifikasi' AND Auth::user()->role == 'pptk')
          <td>Data Harus di Verifikasi PPTK</td>
          @elseif($data->status == 'Terima' AND Auth::user()->role == 'subbag')
          <td>Data Harus di Verifikasi</td>
          @else
          <td>{{$data->status}}</td>
          @endif
          @if(Auth::user()->role == 'admin' OR Auth::user()->role == 'pptk' AND $data->status=='Pending')
          <td>
            <a onclick="accForm('{{$data->id_pengajuan}}')" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></a>
            <a onclick="tolakForm('{{$data->id_pengajuan}}')" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
          </td>
          @elseif(Auth::user()->role == 'member' AND $data->status=='Terima')
          <td>
            <a href="spj/print/{{$data->id_pengajuan}}" target="_blank" class="btn btn-success"><i class="glyphicon glyphicon-print"></i></a>
            <a href="#" class="btn btn-success" disabled><i class="glyphicon glyphicon-ok"></i></a>

          </td>
          @elseif(Auth::user()->role == 'subbag' AND $data->status=='Pending')
          <td>
            <a href="#" class="btn btn-success" disabled><i class="glyphicon glyphicon-ok"></i></a>
          </td>
          @elseif(Auth::user()->role == 'pptk' AND $data->status=='Verifikasi')
          <td>
            <a href="#" class="btn btn-success" disabled><i class="glyphicon glyphicon-ok"></i></a>
            <a data-toggle="modal" data-target="#editForm{{$data->id_pengajuan}}" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i></a>
          </td>@elseif(Auth::user()->role == 'pptk' AND $data->status=='Terima')
          <td>
            <a href="#" class="btn btn-success" disabled><i class="glyphicon glyphicon-ok"></i></a>
          </td>
          @elseif(Auth::user()->role == 'member' AND $data->status=='Pending')
          <td>
            <a data-toggle="modal" data-target="#editForm{{$data->id_pengajuan}}" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i></a>
          </td>
          @elseif(Auth::user()->role == 'member' AND $data->status=='Verifikasi')
          <td>
            <a href="spj/formVerifikasi/{{$data->id_pengajuan}}" class="btn btn-success"><i class="glyphicon glyphicon-new-window"></i></a>
          </td>
          @elseif(Auth::user()->role == 'admin' OR Auth::user()->role == 'subbag' AND $data->status=='Terima')
          <td>
            <a onclick="kurangiSaldo('{{$data->id_pengajuan}}')" class="btn btn-success"><i class="glyphicon glyphicon-ok "></i></a>
            <a onclick="Tolakverif('{{$data->id_pengajuan}}')" class="btn btn-danger"><i class="glyphicon glyphicon-remove "></i></a>
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>  
  </div>
</div>
</div>  
</div>
<div role="tabpanel" class="tab-pane" id="terima">
  <div class="panel panel-default panel-spj">
    <div class="panel-body">
      <h3 style="margin:0;">List Permintaan SPJ <small>(Selesai)</small></h3>
      <hr><div class="table-responsive">
        <table id="table_selesai" class="table table-striped table-no-bordered table-hover" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th style="width: 100px;">Biaya</th>
              <th>Nama Rapat</th>
              <th>Tanggal Rapat</th>
              <th>Status</th>
              <th class="disabled-sorting">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($selesai as $data)
            <tr>
              <td>{{$data->id_pengajuan}}-{{date('Y')}}</td>
              <td>{{$data->name}}</td>
              <td>{{"Rp " . number_format($data->total_fix,2,',','.')}}</td>
              <td>{{$data->nama_rapat}}</td>
              <td>{{$data->tanggal_rapat}}</td>
              <td>{{$data->status}}</td>
              @if(Auth::user()->role == 'member')
              <td>
                <a href="spj/print/{{$data->id_pengajuan}}" target="_blank" class="btn btn-success"><i class="glyphicon glyphicon-print"></i></a>
                @else
                <td>
                  <a href="#" class="btn btn-success" disabled><i class="glyphicon glyphicon-ok "></i></a>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>  
        </div> 
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="tolak">
    <div class="panel panel-default panel-spj">
      <div class="panel-body">
        <h3 style="margin:0;">List Permintaan SPJ <small>(Tolak)</small></h3>
        <hr>
        <div class="table-responsive">
          <table id="table_tolak" class="table table-striped table-no-bordered table-hover" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th style="width: 100px;">Biaya</th>
                <th>Nama Rapat</th>
                <th>Tanggal Rapat</th>
                <th>Status</th>
                <th class="disabled-sorting">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tolak as $data)
              <tr>
                <td>{{$data->id_pengajuan}}-{{date('Y')}}</td>
                <td>{{$data->name}}</td>
                <td>{{"Rp " . number_format($data->total,2,',','.')}}</td>
                <td>{{$data->nama_rapat}}</td>
                <td>{{$data->tanggal_rapat}}</td>
                @if($data->status == 'Tolak')
                <td>Data di Tolak PPTK</td>
                @elseif($data->status == 'Tolak1')
                <td>Data di Tolak Subbag Keuangan</td>
                @endif
                @if(Auth::user()->role == 'member' AND $data->status=='Tolak')
                <td>
                  <a data-toggle="modal" data-target="#editForm{{$data->id_pengajuan}}" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i></a>
                </td>
                @elseif($data->status=='Tolak' OR $data->status=='Tolak1')
                <td>
                  <a href="#" class="btn btn-danger" disabled><i class="glyphicon glyphicon-remove "></i></a>
                </td>
                @elseif(Auth::user()->role == 'member' AND $data->status=='Tolak1')
                <td>
                  <a href="spj/formVerifikasi/{{$data->id_pengajuan}}" class="btn btn-success"><i class="glyphicon glyphicon-new-window"></i></a>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>  
        </div> 
      </div>
    </div>
  </div>
</div>    
</div>
@foreach($tolak as $modal)
<div class="modal fade" id="editForm{{$modal->id_pengajuan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data</h4>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0);" id="formubahspj" method="post" accept-charset="utf-8">
<!--                    <div class="form-group">
                      <label class="custom-control-label" for="customSwitch1">Booking</label>
                      <div class="switch_box box_1">
                         <input  @if($modal->status=='booking')checked ;@endif type="checkbox" onclick="Booking()" id="switch" class="switch_1">
                     </div>
                 </div> -->
                 <!-- tolong tambahin button switch -->
                 <div class="form-group">
                    <label for="inputevent">Nama Rapat</label>
                    <input type="text" name="nama_rapat" class="form-control" value="{{$modal->nama_rapat}}" placeholder="Nama Rapat" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="keterangan">Tanggal Rapat</label>
                    <input type="text" class="form-control" name="tgl_rapat" id="tanggal" value="{{date('m/d/Y',strtotime($modal->tanggal_rapat))}}" autocomplete="off">
                </div>
                <label for="keterangan">Snack</label>
                <div class="form-group input-group">
                    <input type="number" class="form-control" id="snack" onkeyup="jumlahharga()" value="{{$modal->snack}}" name="snack" autocomplete="off">
                    <span class="input-group-addon">BOX</span>
                </div>
                <label for="keterangan">Makan Siang</label>
                <div class="form-group input-group">
                    <input type="number" class="form-control" id="makan" onkeyup="jumlahharga()" name="makan" value="{{$modal->makan}}" autocomplete="off">
                    <span class="input-group-addon">BOX</span>
                </div>
                <div class="form-group">
                    <label for="keterangan">Total</label>
                    <input type="number" readonly class="form-control" name="total" id="total" value="{{$modal->total}}" autocomplete="off">
                    <input type="hidden" value="{{$modal->status}}" id="booking" readonly class="form-control" name="status" >
                    <input type="hidden" value="{{$modal->id_pengajuan}}" class="form-control" name="id_form" >
                </div>
                <button type="submit" class="btn btn-primary pull-right">Ubah</button>
            </form>
        </div>
    </div>
</div>
</div>
@endforeach
@foreach($pending as $modal)
<div class="modal fade" id="editForm{{$modal->id_pengajuan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data</h4>
        </div>
        <div class="modal-body">
            <form action="javascript:void(0);" id="formubahspj" method="post" accept-charset="utf-8">
<!--                    <div class="form-group">
                      <label class="custom-control-label" for="customSwitch1">Booking</label>
                      <div class="switch_box box_1">
                         <input  @if($modal->status=='booking')checked ;@endif type="checkbox" onclick="Booking()" id="switch" class="switch_1">
                     </div>
                 </div> -->
                 <!-- tolong tambahin button switch -->
                 <div class="form-group">
                    <label for="inputevent">Nama Rapat</label>
                    <input type="text" name="nama_rapat" class="form-control" value="{{$modal->nama_rapat}}" placeholder="Nama Rapat" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="keterangan">Tanggal Rapat</label>
                    <input type="text" class="form-control" name="tgl_rapat" id="tanggal" value="{{date('m/d/Y',strtotime($modal->tanggal_rapat))}}" autocomplete="off">
                </div>
                <label for="keterangan">Snack</label>
                <div class="form-group input-group">
                    <input type="number" class="form-control" id="snack" onkeyup="jumlahharga()" value="{{$modal->snack}}" name="snack" autocomplete="off">
                    <span class="input-group-addon">BOX</span>
                </div>
                <label for="keterangan">Makan Siang</label>
                <div class="form-group input-group">
                    <input type="number" class="form-control" id="makan" onkeyup="jumlahharga()" name="makan" value="{{$modal->makan}}" autocomplete="off">
                    <span class="input-group-addon">BOX</span>
                </div>
                <div class="form-group">
                    <label for="keterangan">Total</label>
                    <input type="number" readonly class="form-control" name="total" id="total" value="{{$modal->total}}" autocomplete="off">
                    <input type="hidden" value="{{$modal->status}}" id="booking" readonly class="form-control" name="status" >
                    <input type="hidden" value="{{$modal->id_pengajuan}}" class="form-control" name="id_form" >
                </div>
                <button type="submit" class="btn btn-primary pull-right">Ubah</button>
            </form>
        </div>
    </div>
</div>
</div>
@endforeach
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
      $('#table_selesai').DataTable();
      $('#table_tolak').DataTable();
      $("#tanggal").datepicker();
      $(document).on('blur', '.table_data', function(){
        var id_saldo = $(this).data('row_id');
        var value = $(this).text();
        $.ajax({
          url:BASE_URL + '/spj/editsaldo',
          method:"POST",
          data:{id_saldo:id_saldo, value:value},
          headers: {'X-CSRF-TOKEN': CSRF},
          success:function(data)
          {
            console.log('Berhasil');
        }
    })
    });
  });
   $(function () {
      $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<script type="text/javascript">
 $('.saldo').on('input','.input-saldo',function(){
    var totalSum = 0;
    $('.saldo .input-saldo').each(function(){
       var inputVal = this.value.replace(',','');
       if($.isNumeric(inputVal)){
          totalSum+=parseFloat(inputVal);
      }
  });
    $('#sum_saldo').val(totalSum);
});
 
</script>
@endsection