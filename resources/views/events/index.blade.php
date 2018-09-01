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
                <i class="fa fa-users"></i> event
                @if(Auth::user()->role=='admin')
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Buat Event</button>
                </div>
                @endif
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="javascript:void(0);" id="eventscreate" method="post" accept-charset="utf-8">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="inputevent">Nama Event</label>
                        <input type="text" name="nama_events" class="form-control" id="inputevent" placeholder="Nama Event">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="ket" id="keterangan" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="awal">Waktu Mulai Event</label>
                        <input type="text" class="form-control" name="awal" id="awal" placeholder="Waktu Mulai Evente">
                    </div>
                    <div class="form-group">
                        <label for="akhir">Waktu Akhir Event</label>
                        <input type="text" class="form-control" name="akhir" id="akhir" placeholder="Waktu AKhir Event">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="row">
    @if($data->count() == 0)

    <div class="alert-message alert-message-default">
        <h4>Belum ada Event</h4>
    </div>


    @else
    @foreach($data as $dataevent)
    <div class="panel panel-default panel-google-plus panel-post" id="panel-post-event-{{ $dataevent->id_events }}">
        <!-- @if($dataevent->checkOwner($user->id)) -->
        <div class="dropdown">
            <span class="dropdown-toggle" type="button" data-toggle="dropdown" id="dd1">
                <span class="glyphicon glyphicon-chevron-down"></span>
            </span>
            <ul class="dropdown-menu" aria-labelledby="dd1">
                <li><a href="javascript:;" onclick="deleteEvent({{ $dataevent->id_events }})"><i class="fa fa-fw fa-trash" aria-hidden="true"></i> Delete</a></li>
            </ul>
        </div>
        <!-- @endif -->
        <div class="panel-heading" style="background:none;">
            <img class="img-circle pull-left" src="{{ $dataevent->user->getPhoto(60,60) }}" alt="{{ $dataevent->user->name }}" />
            <a href="{{ url('/'.$dataevent->user->username) }}"><h3 style="margin-top: 3px !important;color: #222;">Nama Event : {{ $dataevent->nama_event }}</h3></a>
            <h5> - <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $dataevent->tanggal->diffForHumans() }}</span> </h5>
        </div>
        <div class="panel-body">
            <strong>Event akan di mulai Tanggal {{ $dataevent->mulai }} Dan Akan Berakhir {{ $dataevent->akhir }}</strong>
            <p>{{ $dataevent->keterangan }}</p>

            <hr class="fix-hr">
            <div class="comments-title-event">
                @include('events.widgets.comments_title')
            </div>
            <div class="post-comments-event">
                @foreach($dataevent->comments()->limit(NULL)->orderBY('id', 'DESC')->with('user')->get()->reverse() as $comment)

                @include('events.widgets.single_comment')

                @endforeach
            </div>
        </div>
        <div class="panel-footer">
            <div class="input-placeholder">Add a comment...</div>
        </div>
        <div class="panel-google-plus-comment">
            <img class="img-circle" src="{{ $user->getPhoto(40,40) }}" alt="User Image" />
            <div class="panel-google-plus-textarea">
                <form id="form-new-comment-event">
                    <textarea rows="4" style="width: 100%;resize: none;"></textarea>
                    <a href="javascript:void(0)" class="btn btn-warning" onclick="submitCommentEvents({{ $dataevent->id_events }})">Post comment</a>
                </form>
                <button type="reset" style="margin-top: -34px;margin-right: 0;float: right;" class="btn btn-default">Cancel</button>
            </div>
            <div class="clearfix"></div>
        </div>
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