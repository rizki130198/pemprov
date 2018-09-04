<style type="text/css">
.media{
    margin-top: 10px;
}
.panel-follow{
    margin-top: 20px;
}
..autocomplete {
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
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
<div class="panel-follow" style="margin-top: 0;">
    <div class="panel-body" style="padding: 10px 20px;">
        <h5 style="color: #90949c;"><strong>TAMBAHKAN ANGGOTA</strong></h5> 
            <form autocomplete="off" action="">
                <div class="autocomplete" style="width:100%;">
                    <input id="" type="text" name="" placeholder="Cari Anggota">
                </div>
            </form>
        </div>
    </div>

    <div class="panel-follow">
        <div class="panel-body" style="padding: 10px 20px;">
            <h5 style="color: #90949c;"><strong>ANGGOTA</strong> <span class="pull-right" style="font-size: 14px;margin-top: 3px;"><a href="#">29 Anggota</a></span></h5>
            <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="https://st2.depositphotos.com/2703645/7676/v/950/depositphotos_76762205-stock-illustration-male-avatar-icon.jpg" alt="" width="48px" height="48px">
            <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="https://st2.depositphotos.com/2703645/7676/v/950/depositphotos_76762205-stock-illustration-male-avatar-icon.jpg" alt="" width="48px" height="48px">
            <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="https://st2.depositphotos.com/2703645/7676/v/950/depositphotos_76762205-stock-illustration-male-avatar-icon.jpg" alt="" width="48px" height="48px">
            <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="https://cdn.iconscout.com/icon/free/png-256/avatar-372-456324.png" alt="" width="48px" height="48px">
            <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="https://cdn.iconscout.com/icon/free/png-256/avatar-372-456324.png" alt="" width="48px" height="48px">
            <img style="display: inline-block;margin-right: 3px;border-radius: 50%;" class="m3dia-object" src="https://cdn.iconscout.com/icon/free/png-256/avatar-372-456324.png" alt="" width="48px" height="48px">
            <hr>
            <h5 style="color: #90949c;"><strong>SARAN ANGGOTA</strong></h5>
            @foreach(Auth::user()->suggestedPeopleGrup(3) as $user)
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
                            {!! sHelper::followButton($user->id, Auth::id(), '#people-listed-'.$user->id, 'btn-sm') !!}
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            <center style="margin-top: 10px;"><a href="">Liat Selengkapnya</a></center>
        </div>
    </div>

    <div class="panel-follow">
        <div class="panel-body" style="padding: 10px 20px;">
            <h5 style="color: #90949c;"><strong>FOTO GRUP</strong> <span class="pull-right" style="font-size: 14px;margin-top: 3px;"><a href="#">Lihat Semua</a></span></h5>
            <img style="display: inline-block;margin-right: 3px;" src="http://www.intrawallpaper.com/static/images/Hawaii-Beach-Wallpaper-HD_H47ejc9.jpg" alt="" width="102.8px" height="102.8px">
            <img style="display: inline-block;margin-right: 3px;" src="https://www.planwallpaper.com/static/images/2015-wallpaper_111525594_269.jpg" alt="" width="102.8px" height="102.8px">
            <img style="display: inline-block;margin-right: 3px;" src="https://www.planwallpaper.com/static/images/3865967-wallpaper-full-hd_XNgM7er.jpg" alt="" width="102.8px" height="102.8px">
        </div>
    </div>