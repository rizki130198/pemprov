<div class="clearfix"></div>
@if($user->id == Auth::user()->id)
<div class="new-post-box">
    <div class="well well-sm well-social-post" style="border-top:solid 4px #e8b563;">
        <form id="form-new-post" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="panel-heading" style="border-bottom: solid 1px #ddd;border-radius: 0;background-color: #fff;"><i class="glyphicon glyphicon-pencil"></i> Buat Postingan Berita</div>
            <div class="panel-body">
                <input style="min-height: auto;" type="text" class="form-control" placeholder="Judul Berita">
            </div>
            <textarea id="isi" class="form-control text-post" name="content" placeholder="Apa yang Anda pikirkan, {{ Auth::user()->name }}?" style="resize:none;"></textarea>
            <div class="image-area">
                <a href="javascript:;" class="image-remove-button" onclick="removePostImage()"><i class="fa fa-times-circle"></i></a>
                <img src="" />
            </div>

            <output id="listimage"></output>
            <!-- <output id="list"></output> -->
            <div class="row row-res" style="padding: 10px;">
                <p style="padding-left: 15px;">Cover Berita</p>
                <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostImage()" style="margin-left: 15px;">
                    <i class="fa fa-image"></i> Tambah Foto
                </button>
                <input type="file" id="uploadimage" accept="image/*" multiple class="image-input" name="photo[]" onchange="previewPostImage(this)">
                <!-- <button type="button" class="btn btn-default btn-add-image btn-sm" onclick="uploadPostFile()">
                    <i class="glyphicon glyphicon-file"></i> Tambah File
                </button> -->
                <input type="file" class="file-input" id="uploadfile" multiple name="file[]" onchange="previewPostFile(this)">
                <div class="loading-post">
                    <img src="{{ asset('images/rolling.gif') }}" alt="">
                </div>
                <button type="button" class="btn btn-warning btn-submit pull-right" onclick="newPost()" style="margin-right: 15px;">
                    Bagikan
                </button>
            </div>
        </form>
    </div>
</div>
@endif
<div class="panel panel-default" id="">
    <div class="panel-body">
        <div class="media-list" style="margin-bottom: 20px;border-bottom:solid 1px #ddd">
            <h4 style="text-transform: uppercase;font-weight: bold;">berita populer</h4>
            <div class="double-line-populer"></div>
            <a href="">
                <img class="media-object" src="https://img.jakpost.net/c/2018/09/24/2018_09_24_54590_1537803434._large.jpg" alt="" width="100%" height="250" style="padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
            </a>
            <p style="margin-top: 10px;font-size: 14px;border-left:solid 2px #6FB01E;height: 15px;line-height: 15px;padding-left: 5px;">
                Administrator / 20 Sep 18
            </p>
            <a href="" style="text-decoration: none;color: #555;"><h4 class="media-heading" style="font-weight: bold;margin-top: 7px;">Tool belts and cycling shorts trending at Milan Fashion Week</h4></a>
            <p style="color: #a2a2a2;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis.</p>
        </div>
        <div class="media" style="border-bottom:solid 1px #ddd">
            <div class="media-left">
                <a href="">
                    <img class="media-object" src="https://img.jakpost.net/c/2018/09/25/2018_09_25_54629_1537810669._thumbnail.jpg" alt="" width="120" height="120" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                </a>
            </div>
            <div class="media-body">
                <a href="" style="text-decoration: none;color: #555;"><h4 class="media-heading" style="font-weight: bold;margin-top: 7px;">Tool belts and cycling shorts trending at Milan Fashion Week</h4></a>
                <p style="margin-top: 10px;font-size: 14px;border-left:solid 2px #d5483c;height: 15px;line-height: 15px;padding-left: 5px;">
                    Administrator / 20 Sep 18
                </p>
                <p style="color: #a2a2a2;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis.</p>
            </div>
        </div>
        <div class="media" style="border-bottom:solid 1px #ddd">
            <div class="media-left">
                <a href="">
                    <img class="media-object" src="https://img.jakpost.net/c/2018/09/24/2018_09_24_54590_1537803434._thumbnail.jpg" alt="" width="120" height="120" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                </a>
            </div>
            <div class="media-body">
                <a href="" style="text-decoration: none;color: #555;"><h4 class="media-heading" style="font-weight: bold;margin-top: 7px;">'Marvel's Spider-Man': Best-ever game about web-slinging superhero</h4></a>
                <p style="margin-top: 10px;font-size: 14px;border-left:solid 2px #d5483c;height: 15px;line-height: 15px;padding-left: 5px;">
                    Administrator / 20 Sep 18
                </p>
                <p style="color: #a2a2a2;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis.</p>
            </div>
        </div>
        <div class="media" style="border-bottom:solid 1px #ddd">
            <div class="media-left">
                <a href="">
                    <img class="media-object" src="https://img.jakpost.net/c/2018/09/25/2018_09_25_54634_1537836961._thumbnail.jpg" alt="" width="120" height="120" style="border-radius: 5%;padding: 3px;margin-bottom: 10px;border: 1px solid #ddd;">
                </a>
            </div>
            <div class="media-body">
                <a href="" style="text-decoration: none;color: #555;"><h4 class="media-heading" style="font-weight: bold;margin-top: 7px;">Modric ends Ronaldo-Messi era to be crowned world's best</h4></a>
                <p style="margin-top: 10px;font-size: 14px;border-left:solid 2px #d5483c;height: 15px;line-height: 15px;padding-left: 5px;">
                    Administrator / 20 Sep 18
                </p>
                <p style="color: #a2a2a2;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis.</p>
            </div>
        </div>
    </div>    
</div>    
<div class="post-list-top-loading">
    <img src="{{ asset('images/rolling.gif') }}" alt="">
</div>
<div class="post-list">

</div>
<div class="post-list-bottom-loading">
    <img src="{{ asset('images/rolling.gif') }}" alt="">
</div>

<!-- <div class="modal fade " id="likeListModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Suka</h5>
            </div>

            <div class="user_list">

            </div>
        </div>
    </div>
</div> -->