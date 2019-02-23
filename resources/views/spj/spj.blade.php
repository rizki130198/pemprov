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
        <div class="col-md-3 col-md-offset-3 col-xs-12">
	            <div class="panel panel-default" style="border-radius: 10px;background: #42a5f5;background: -webkit-linear-gradient(45deg, #42a5f5, #00B4DB);background: linear-gradient(45deg, #42a5f5, #00B4DB);">
	                <a data-toggle="modal" data-target="#info">
	                	<button class="btn btn-default pull-right btn-xs" type="button" style="display: inline-block;float: right;border-radius: 20px;width: 40px;font-weight: bold;border:none;margin: 15px;">Info</button>
	                </a>
        			<a href="{{url('/spj/formSpj')}}">
		                <div class="panel-body">
		                	<br>
		                	<h4 style="color: #fff;letter-spacing: 3px;font-weight: bold;">Biaya Anggaran</h4>
		                	<h5 style="color: #fff;">Rp 500.000.000,-</h5>
		                </div>
            		</a>
	            </div>          
        </div>

        <!-- <div class="col-md-3 col-xs-12 col-md-offset-3">
        	<a href="{{url('/formSpj')}}">
	            <div class="panel panel-default" style="border-radius: 10px;background: #FDC830;background: -webkit-linear-gradient(45deg, #F37335, #FDC830);background: linear-gradient(45deg, #F37335, #FDC830);">
	                <div class="panel-body">
	                	<button class="btn btn-default pull-right btn-xs" style="display: inline-block;float: right;border-radius: 20px;width: 40px;">Info</button>
	                	<br>
	                	<h4 style="color: #fff;letter-spacing: 3px;font-weight: bold;">Biaya Anggaran 2</h4>
	                	<h5 style="color: #fff;">Rp 500.000.000,-</h5>
	                </div>
	            </div>     
            </a>     
        </div> -->
        <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        	<div class="modal-dialog" role="document">
        		<div class="modal-content">
        			<form action="javascript:void(0);" id="grupcreate" method="post" accept-charset="utf-8">
        				<div class="modal-body">
        					<h4>Info Biaya Anggaran</h4>
        					<hr>
        					<table>
	                            <tr>
	                            	<td>Pagu Snack </td> 
	                            	<td style="padding: 3px;"> :</td>
	                            	<td>Rp 118.000.000</td>
	                            </tr>
	                            <tr>
	                            	<td>Pagu Makan Siang </td> 
	                            	<td style="padding: 3px;"> :</td>
	                            	<td>Rp 310.200.000</td>
	                            </tr>
	                            <tr>
	                            	<td><label>Pagu Total </label></td>
	                            	<td style="padding: 3px;"> :</td>
	                            	<td>Rp 429.000.000</td>
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
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                	<h3 style="margin:0;">List Permintaan SPJ</h3>
                	<hr>
                    <table id="table_pengguna" class="table table-striped table-no-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th style="width: 100px;">Biaya</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th class="disabled-sorting">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>rizki</td>
                                <td>Rp 200.000</td>
                                <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua...</td>
                                <td>Pending</td>
                                <td>
                                    <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Fahmi</td>
                                <td>Rp 200.000.000</td>
                                <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua...</td>
                                <td>Diterima</td>
                                <td>
                                    <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>        
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