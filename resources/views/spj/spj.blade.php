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
        <div class="col-md-2 col-md-offset-3 col-xs-12">
        	<a href="{{url('/formSpj')}}">
	            <div class="panel panel-default" style="border-radius: 10px;background: #00B4DB;background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);background: linear-gradient(to right, #0083B0, #00B4DB);">
	                <div class="panel-body">
	                	<h4 style="color: #fff;letter-spacing: 3px;font-weight: bold;">Biaya Anggaran 1</h4>
	                	<h5 style="color: #fff;">Rp 500.000.000,-</h5>
	                </div>
	            </div>          
            </a>
        </div>
        <div class="col-md-2 col-xs-12">
        	<a href="{{url('/formSpj')}}">
	            <div class="panel panel-default" style="border-radius: 10px;background: #FDC830;background: -webkit-linear-gradient(to right, #F37335, #FDC830);background: linear-gradient(to right, #F37335, #FDC830);">
	                <div class="panel-body">
	                	<h4 style="color: #fff;letter-spacing: 3px;font-weight: bold;">Biaya Anggaran 2</h4>
	                	<h5 style="color: #fff;">Rp 500.000.000,-</h5>
	                </div>
	            </div>     
            </a>     
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