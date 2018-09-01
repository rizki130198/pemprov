@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-9">
            <div class="content-page-title">
                <i class="fa fa-users"></i> Groups
                @if(Auth::user()->role=='admin')
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Buat Group</button>
                </div>
                @endif
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="javascript:void(0);" id="grupcreate" method="post" accept-charset="utf-8">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="inputGrup">Nama Grup</label>
                        <input type="text" name="nama_grup" class="form-control" id="inputGrup" placeholder="Nama Grup">
                    </div>
                   <!--  <div class="form-group">
                        <label for="gambar">Cover Image</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Cover Grup">
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>

            </form>
        </div>
    </div>
</div>
@if($groups->count() == 0)

<div class="alert-message alert-message-default">
    <h4>Belum ada group</h4>
</div>

@else

<div class="row">

    @foreach($groups->get() as $group)

    <div class="col-sm-6 col-md-4">
        <a class="bs-box" href="{{ url('/group/'.$group->id_grup) }}">
            <h3>{{ $group->nama_grup }}</h3>
        </a>
    </div>

    @endforeach



</div>
@endif


</div>
</div>
</div>



@endsection

@section('footer')

@endsection