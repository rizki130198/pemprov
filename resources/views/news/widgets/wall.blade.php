<style type="text/css">
.btn-more {
    width: 33px;
    height: 30px;
    background-color: #eee;
}
.btn-more > i {
    font-size: 16px;
    color: #929292;
}
.btn-more:hover {
    background-color: #F9F9F9;
}
.media-body p img{
    display: none;
}
</style> 
<div class="clearfix"></div>
@if($user->id == Auth::user()->id AND $user->role == 'admin')
<div class="new-post-box">
    <div class="well well-sm well-social-post" style="border-top:solid 4px #e8b563;">
        <form action="/news/new" id="form-news" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="panel-heading" style="border-bottom: solid 1px #ddd;border-radius: 0;background-color: #fff;"><i class="glyphicon glyphicon-pencil"></i> Buat Postingan Berita</div>
            <div class="panel-body">
                <input required style="min-height: auto;" type="text" name="judul" class="form-control" placeholder="Judul Berita">
            </div>
            <textarea id="isi" class="form-control text-post" name="content" placeholder="Ada Berita Terbaru Apa, {{ Auth::user()->name }}?" style="resize:none;"></textarea>
            <div class="image-area">
                <a href="javascript:;" class="image-remove-button" onclick="removenewsImage()"><i class="fa fa-times-circle"></i></a>
                <img src="" />
            </div>

            <!-- <output id="listimagenews"></output> -->
            <div class="row row-res" style="padding: 10px;">
                <p style="padding-left: 15px;">Cover Berita</p>
                <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadnewsImage()" style="margin-left: 15px;">
                    <i class="fa fa-image"></i> Tambah Foto
                </button>
                <input type="file" id="uploadimagenews" accept="image/*" class="image-input-news" name="image" onchange="previewnewsImage(this)">
                <div class="loading-post">
                    <img src="{{ asset('images/rolling.gif') }}" alt="">
                </div>
                <button type="SUBMIT" class="btn btn-warning btn-submit pull-right" style="margin-right: 15px;">
                    Bagikan
                </button>
            </div>
        </form>
    </div>
</div>
<div class="modalpostnews"></div>
@endif
@if($news->count() > 0)
<div class="panel panel-default" id="">
    <div class="panel-body">
        @foreach($news->paginate(20) as $berita)
        <div class="media" style="border-bottom:solid 1px #ddd" id="panel-news-gabung-{{$berita->id}}">
            @if(Auth::user()->role == 'admin')
            <div class="dropdown">
                <button class="btn btn-more dropdown-toggle pull-right" id="deleteNews" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="deleteNews" style="top: 33px;">
                    <li role="presentation"><a role="menuitem" href="javascript:;" onclick="deletenews({{ $berita->id }})">Hapus Berita</a></li>
                    <li role="presentation"><a role="menuitem" href="javascript:;" onclick="editnews({{ $berita->id }})">Edit Berita</a></li>
                </ul>
            </div> 
            @endif 
            <div class="media-left">
                <?php 
                $ganti = str_replace(' ', '-',$berita->judul);
                $getimage = str_replace('src=', ' ', substr($berita->isi,0,100))
                ?>
                <a href="baca/{{ date('d/m/y', strtotime($berita->tanggal))}}/{{$ganti}}">
                    @if($berita->cover == NULL)
                    <img class="media-object" src="https://1.bp.blogspot.com/-lMEVMVBC_ck/VzjxJGNy2CI/AAAAAAAACEo/OGAirHkodsofpONDlzKQvsnEm9Ptj0G8wCLcB/s1600/pemerintahan%2Bjakarta.png" alt="" width="120" height="120" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                    @else
                    <img class="media-object" src=" {{ url('storage/uploads/posts/'.$berita->cover) }}" alt="" width="120" height="120" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                    @endif
                </a>
            </div>
            <div class="media-body">
                <a href="baca/{{ date('d/m/y', strtotime($berita->tanggal))}}/{{$ganti}}" style="text-decoration: none;color: #555;"><h4 class="media-heading" style="font-weight: bold;margin-top: 7px;">{{$berita->judul}}</h4></a>
                <p style="margin-top: 10px;font-size: 14px;border-left:solid 2px #d5483c;height: 15px;line-height: 15px;padding-left: 5px;">
                    <strong>{{ Auth::user()->getNameuser($berita->user_id)}}</strong> / {{ date('d F Y - h:i', strtotime($berita->tanggal))}}
                </p>
                <p style="color: #a2a2a2;">{!! $getimage !!}</p>
            </div>
        </div>
        @endforeach
    </div>    

    {{$news->paginate(20)->links()}}
</div>
@endif 
