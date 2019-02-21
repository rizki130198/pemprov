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
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table id="table_pengguna" class="table table-striped table-no-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th class="disabled-sorting">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>rizki</td>
                                <td>admin</td>
                                <td>rizkiaja@gmail.com</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>
                                    <button type="button" class="btn btn-success"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>jamet</td>
                                <td>admin</td>
                                <td>rizkiaja@gmail.com</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>
                                    <button type="button" class="btn btn-success"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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