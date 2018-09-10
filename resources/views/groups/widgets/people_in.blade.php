<style type="text/css">
.media{
  margin-top: 10px;
}
.panel-follow{
  margin-top: 20px;
}
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  display: none;
  right: 0;
}
.autocomplete-items .auto_list div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items .auto_list div:hover {
  background-color: DodgerBlue;
  color: #fff; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
.modal-dialog {
  min-height: calc(100vh - 60px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  overflow: auto;
}
@media(max-width: 768px) {
  .modal-dialog {
    min-height: calc(100vh - 20px);
  }
}
</style>
<div class="panel-follow" style="margin-top: 0;">
  <div class="panel-body" style="padding: 10px 20px;">
    <h5 style="color: #90949c;"><strong>TAMBAHKAN ANGGOTA</strong></h5> 
    <form autocomplete="off" action="">
      <div class="autocomplete" style="width:100%;">
        <input id="getanggota" type="text" name="anggota" onkeyup="tambahanggota()" placeholder="Tambah Anggota">
        <input id="grup" type="hidden" name="grup" value="{{Request::segment(3)}}">
      </div>
      <div id="suggestions" class="autocomplete-items">
        <div id="autoSuggestionsList"></div>
      </div>
   </form>
 </div>
</div>
<div class="panel-follow">
  <div class="panel-body" style="padding: 10px 20px;">
    <h5 style="color: #90949c;"><strong>ANGGOTA</strong> <span class="pull-right" style="font-size: 14px;margin-top: 3px;"><a href="{{ url('/group/anggota/'.$group->id_grup) }}">{{$anggota->count()}}</a></span></h5>
    @foreach($anggota->slice(0,6) as $member)
    @if($member->profile_path!=NULL)
    <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="{{ url('storage/uploads/profile_photos/'.$member->profile_path) }}" alt="{{$member->username}}" width="48px" height="48px">
    @else
    <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="{{ url('images/profile-picture.png') }}" alt="{{$member->username}}" width="48px" height="48px">
    @endif
    @endforeach
    <hr>
    <h5 style="color: #90949c;"><strong>SARAN ANGGOTA</strong></h5>
    @foreach(Auth::user()->suggestedPeopleGrup(3,$group->id_grup) as $user)
    <div class="media">
      <div class="media-left">
        <a href="{{ url('/'.$user->username) }}">
          <img class="media-object" src="{{ $user->getPhoto(50, 50) }}" alt="{{ url('/'.$user->username) }}" width="35px" height="35px" style="border-radius: 50%;">
        </a>
      </div>
      <div class="media-body">
        <a href="{{ url('/'.$user->username) }}" style="text-decoration: none;">
          <h4 class="media-heading" style="font-size: 14px;margin-top: 8px;">{{ '@'.$user->username }}</h4>
          <div id="people-listed-{{ $user->id }}" class="pull-right" style="margin-top: -25px;">
            {!! sHelper::grupButton($group->id_grup, $user->id, '#people-listed-'.$group->id_grup, 'btn-sm') !!}
          </div>
        </a>
      </div>
    </div>
    @endforeach
    <!-- <center style="margin-top: 10px;"><a href="">Liat Selengkapnya</a></center> -->
  </div>
</div>
@if (Request::segment(2) == 'foto')
@else
<div class="panel-follow">
  <div class="panel-body" style="padding: 10px 20px;">
    <h5 style="color: #90949c;"><strong>FOTO GRUP</strong> <span class="pull-right" style="font-size: 14px;margin-top: 3px;"><a href="/group/foto/{{$group->id_grup}}">Lihat Semua</a></span></h5>
    @foreach($images_grup->slice(0,3) as $rowImage)
    <?php $image = explode(',',$rowImage->image_path); ?>
    @for($i = 0; $i < count($image); $i++) 
    <img style="display: inline-block;margin-right: 3px;" src="{{ url('storage/uploads/posts/'.$image[$i]) }}" width="102.8px" height="102.8px">
    
    @endfor
    @endforeach
  </div>
</div>
@endif
