<div class="panel panel-default suggested-people">
    <div class="panel-heading">Invite Teman</div>
    <div class="user_list">
    @if($user_list->count() == 0)
    <div class="alert alert-danger" role="alert" style="margin: 10px;">Tidak ada Teman!</div>
    @else
    <div class="form-group">
        <input type="text" class="form-control" id="modal-search"  onkeyup="searchUserList()" placeholder="Search for names..">
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
    <ul class="list-group">
        @foreach(Auth::user()->suggestedPeopleGrup(10,$group->id_grup) as $user)
        <li class="list-group-item">
            <div class="col-xs-12 col-sm-3">
                <a href="{{ url('/'.$user->username) }}">
                    <img src="{{ $user->getPhoto(50, 50) }}" alt="{{ $user->name }}" class="img-circle" />
                </a>
            </div>
            <div class="col-xs-12 col-sm-9">
                <a href="{{ url('/'.$user->username) }}">
                    <span class="name">{{ $user->name }}</span><small>{{ '@'.$user->username }}</small><br />
                </a>
                <div id="people-listed-{{ $user->id }}">
                    Invite
                   {!! sHelper::followButton($user->id, Auth::id(), '#people-listed-'.$user->id, 'btn-sm') !!} 
                </div>
            </div>
            <div class="clearfix"></div>
        </li>
        @endforeach
    </ul>
</div>
