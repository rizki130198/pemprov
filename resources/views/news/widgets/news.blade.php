<div class="panel-follow" style="margin-bottom: 20px;">
    <div class="panel-body" style="padding: 10px 20px;">
        <h5 style="color: #90949c;"><strong>Berita Terbaru</strong></h5> 
        <div class="double-line-news"></div>
        @foreach(Auth::user()->news()->limit(3)->orderBy('id','Desc')->get() as $berita)
        <div class="media">
            <div class="media-left">
                <?php 
                    $ganti = str_replace(' ', '-',$berita->judul);
                ?>
                <a href="baca/{{ date('d/m/y', strtotime($berita->tanggal))}}/{{$ganti}}">
                    @if($berita->cover == NULL)
                    <img class="media-object" src="https://1.bp.blogspot.com/-lMEVMVBC_ck/VzjxJGNy2CI/AAAAAAAACEo/OGAirHkodsofpONDlzKQvsnEm9Ptj0G8wCLcB/s1600/pemerintahan%2Bjakarta.png" alt="" width="80" height="80" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                    @else
                    <img class="media-object" src="{{ url('storage/uploads/posts/'.$berita->cover) }}" alt="" width="80" height="80" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                    @endif
                </a>
            </div>
            <div class="media-body">
                <p style="margin-top: 2px;font-size: 14px;border-left:solid 2px #d5483c;height: 15px;line-height: 15px;padding-left: 5px;">
                    {{Auth::user()->getNameuser($berita->user_id)}} / {{ date('d M y', strtotime($berita->tanggal))}}
                </p>
                <a href="baca/{{ date('d/m/y', strtotime($berita->tanggal))}}/{{$ganti}}" style="text-decoration: none;color: #555;"><h4 class="media-heading" style="font-size: 14px;font-weight: bold;margin-top: -2px;">{{$berita->judul}}</h4></a>
            </div>
        </div>
        @endforeach
    </div>
</div>