@extends('layouts.app')

@section('content')
    <div class="h-20"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-3" style="padding-left: 0;position: fixed;">
                @include('widgets.sidebar')
            </div>
            <div class="col-md-8 col-md-offset-3 col-xs-12" style="margin-bottom: 30px;">
                <div class="content-page-title">
                    <i class="fa fa-commenting"></i> Pesan Langsung
                </div>
                <div class="new-message-button">
                    <button class="btn btn-success" style="background-color: #5fba7d !important;background: none;" type="button" data-toggle="modal" data-target="#userListModal">
                        <i class="fa fa-commenting"></i> Pesan Baru
                    </button>
                </div>
                <div class="dm">
                    <div class="friends-list">

                    </div>
                    <div class="chat">

                    </div>
                </div>
                <div class="modal fade " id="userListModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title">Pesan Baru</h5>
                            </div>

                            <div class="user_list">
                                @if($user_list->count() == 0)
                                    <div class="alert alert-danger" role="alert" style="margin: 10px;">Tidak ada orang!</div>
                                @else
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="modal-search"  onkeyup="searchUserList()" placeholder="Cari nama..">
                                    </div>
                                    <table id="modal-table">
                                        @foreach($user_list->get() as $f)
                                            <tr>
                                                <td>
                                                    <a href="javascript:;" onclick="showChat({{ $f->follower->id }})">
                                                        <div class="image">
                                                            <img src="{{ $f->follower->getPhoto(50, 50) }}" alt="{{ $f->follower->name }}" class="img-circle" />
                                                        </div>
                                                        <div class="detail">
                                                            <strong>{{ $f->follower->name }}</strong>
                                                            <small>{{ '@'.$f->follower->username }}</small>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection

@section('footer')
    <script type="text/javascript">
        @if($show)
            var initial_dm = 1;
        @else
            var initial_dm = 0;
        @endif
    </script>
    <script src="{{ asset('js/dm.js') }}"></script>
    <script type="text/javascript">
        @if($show)
            $(function() {
                showChat({{ $id }});
            });
        @endif
    </script>
@endsection