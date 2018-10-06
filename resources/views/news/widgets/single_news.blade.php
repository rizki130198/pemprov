@extends('layouts.app')

@section('content')
<style type="text/css">
.col-md-offset-3{
    margin-left: 21%;
}
.descrip{
    display: block;
    float: left;
    width: 100%;
    margin: .5em 0 0;
    text-transform: none;
}
.descrip span {
    color: #b2b3b3;
    display: inline-block;
    font-size: 1.22em;
    font-weight: 100;
}
.panel-body p img{
    width: 100% !important;
    height: auto !important;
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
                @include('widgets.suggested_people')
            </div>
        </div>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="clearfix"></div>
            <div class="panel panel-default" id="">
                @foreach($getdata->get() as $berita)
                <div class="panel-body">
                    <div id="crumbs">
                        <ul>
                            <?php 
                            $ganti = str_replace(' ', '-',$berita->judul); ?>
                            <li><a href="/news"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                            <li><a href="/baca/{{ date('d/m/y', strtotime($berita->tanggal))}}/{{$ganti}}">{{ $berita->judul }}</a></li>
                            <li><a href="/baca/{{ date('d/m/y', strtotime($berita->tanggal))}}/{{$ganti}}">Detail Berita</a></li>
                        </ul>
                    </div>
                    <hr>
                    <h1 style="font-size: 42px;line-height: 1.2;padding: 0 0 .3em;">{{ $berita->judul }}</h1>
                    <h5 style="text-transform: uppercase;color: #dc2027;">Oleh  {{ Auth::user()->getNameuser($berita->user_id)}}</h5>
                    <div class="descrip">
                        <span class="day">{{date('D, F, d, y', strtotime($berita->tanggal))}}</span>
                        <span class="time"> | {{date('h:i A', strtotime($berita->tanggal))}}</span>
                    </div>
                </div>    
                <img class="media-object" src=" {{ url('storage/uploads/posts/'.$berita->cover) }}" alt="" width="50%" style="margin-left: 15px;margin-bottom: 10px;">
                <div class="panel-body" id="panel-news-{{$berita->id}}" style="padding-top: 0;">   
                    <?php preg_replace('/style=\"*\"/', "", $berita->isi) ?> 
                    <p>{!! $berita->isi !!}</p>
                    <div class="panel panel-default" style="margin:5% auto;background-color: #ddd;border-radius: 0;">
                        <div class="panel-body" style="padding: 8px;">
                            <h3 style="margin: 0;color: #8d8d8d;text-transform: uppercase;font-size: 18px;">Komentar</h3>
                        </div>
                    </div>
                    <div class="well well-sm well-social-post" style="margin-top: 0;border-top:solid 4px #e8b563;border-radius: 2px;box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <form id="news_comment" action="/news/comment/{{$berita->id}}" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <textarea id="komentar" class="form-control text-post" maxlength="500" name="content" placeholder="Berikan komentar anda, {{ Auth::user()->name }}." style="resize:none;"></textarea>
                            <!-- <output id="listimagenews"></output> -->
                            <div class="row row-res" style="padding: 10px;">
                                <span id="max_komentar" style="padding-right: 5px;color: #dc2027;padding-left: 20px;">500</span> Karakter terisisa
                                <button type="submit" class="btn btn-warning btn-submit pull-right" style="margin-right: 15px;">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                    <label style="font-size: 16px;color: #6F6F6F;" id="hitung-komentar">{{$getcomment->count()}} Komentar</label>
                    @foreach($getcomment->get() as $komen)
                    <div class="panel panel-default" id="panel-komentar-news-{{$komen->id_comment}}" style="background-color: #f8f8f8;border-radius: 2px;box-shadow: 0 2px 2px rgba(0,0,0,0.1);border: 1px solid #e6e6e6;">
                        <div class="panel-body">
                            <div class="media">
                                @if(Auth::user()->role == 'admin' OR $komen->id_user == Auth::user()->id)
                                <div class="dropdown">
                                    <button class="btn btn-more dropdown-toggle pull-right" id="deleteNews" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="deleteNews" style="top: -2px;margin-right: 42px;">
                                        <li role="presentation"><a role="menuitem" href="javascript:;" onclick="removeCommentNews({{ $komen->id_comment }},{{$komen->id}})">Hapus Komentar</a></li>
                                    </ul>
                                </div> 
                                @endif
                                <div class="media-left">
                                    @if ($komen->profile_path == NULL)
                                    <a href="">
                                        <img class="media-object img-circle" src="{{ url('images/profile-picture.png') }}" alt="" width="50px" height="50px">
                                    </a>
                                    @else
                                    <a href="">
                                        <img class="media-object img-circle" src="{{url('storage/uploads/profile_photos/'.$komen->profile_path)}}" alt="" width="50px" height="50px">
                                    </a>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <p style="font-size: 14px;border-left:solid 2px #4990E2;height: 15px;text-transform: uppercase;line-height: 15px;padding-left: 5px;">
                                        {{$komen->name}}
                                    </p>
                                    <!-- <p style="margin-top: -5px;font-size: 13px;"></p> -->
                                    <a href="" style="text-decoration: none;color: #555;">
                                        <h4 class="media-heading news-comments" style="font-size: 15px;margin-top: 7px;">{{$komen->comment}}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> 

                @endforeach   
            </div>
        </div>
    </div>
</div>    
@endsection

@section('footer')
<script type="text/javascript">
    $(document).ready(function(){
        var maxChars = $("#komentar");
        var max_length = maxChars.attr('maxlength');
        if (max_length > 0) {
            maxChars.bind('keyup', function(e){
                length = new Number(maxChars.val().length);
                counter = max_length-length;
                $("#max_komentar").text(counter);
            });
        }
    });
</script>
@endsection