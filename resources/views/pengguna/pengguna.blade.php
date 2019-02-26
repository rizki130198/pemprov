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
                                <th>level</th>
                                <th>Created Date</th>
                                <th class="disabled-sorting">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $user)
                            @if ($user->id != Auth::user()->id)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#ubah{{$user->id}}" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                    <a onclick="deleteuser('{{$user->id}}')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>        
                </div>
            </div>          
        </div>
        @foreach($data as $modal)
        <div class="modal fade" id="ubah{{$modal->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Ubah Jabatan</h4>
              </div>
              <div class="modal-body">
                 <form action="javascript:void(0);" id="ubahjabatan" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="inputevent">Nama</label>
                        <input type="text" name="nama_rapat" class="form-control" disabled value="{{$modal->name}}" placeholder="Nama Rapat" autocomplete="off">
                        <input type="hidden" name="id" class="form-control" value="{{$modal->id}}"autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Username</label>
                        <input type="text" class="form-control" disabled name="tgl_rapat" id="tanggal" value="{{$modal->username}}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Email</label>
                        <input type="text" class="form-control" disabled id="snack" value="{{$modal->email}}" name="snack" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Jabatan</label>
                        <select class="form-control" name="role">
                            <option value="{{$modal->role}}" selected>{{$modal->role}}</option>
                            @if ($modal->role=='admin')
                            <option value="subbag">Subbag Keuangan</option>
                            <option value="pptk">PPTK</option>
                            <option value="member">Member</option>
                            @elseif ($modal->role=='subbag')
                            <option value="admin">Admin</option>
                            <option value="pptk">PPTK</option>
                            <option value="member">Member</option>
                            @elseif ($modal->role=='subbag')
                            <option value="admin">Admin</option>
                            <option value="subbag">Subbag Keuangan</option>
                            <option value="member">Member</option>
                            @elseif ($modal->role=='member')
                            <option value="admin">Admin</option>
                            <option value="subbag">Subbag Keuangan</option>
                            <option value="pptk">PPTK</option>
                            @endif
                        </select>
                    </div>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                     <button type="submit" class="btn btn-primary">Ganti</button>
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
    } );
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function deleteuser(id) {
        $.ajax({
            url: BASE_URL + '/pengguna/delete',
            type: "POST",
            data: {id_usernya : id},
            headers: {'X-CSRF-TOKEN': CSRF},
            success: function (response) {
                if (response.code == 200) {
                    $('#exampleModal2').modal('hide');
                    location.reload();
                } else {
                    $('#errorMessageModal').modal('show');
                    $('#errorMessageModal #errors').html(''+response.message);
                }
            },
            error: function () {
                $('#errorMessageModal').modal('show');
                $('#errorMessageModal #errors').html(''+response.message);
            }
        });
    }
</script>
@endsection