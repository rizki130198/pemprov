<div class="col-sm-3" style="padding-right: 0;position: fixed;right: 0;">
    <div class="panel-follow">
        <div class="panel-heading" style="border-bottom: solid 1px #ddd;padding-right: 20px;padding-left: 20px;"><h4><strong>Saran Groups</strong></h4></div>
        @foreach($grup as $groups)
        @if ($grup->count() == 0)
        Tidak ada Grup Yang cocok
        @else
        <div class="panel-body" style="padding-right: 20px;padding-left: 20px;">
            <div class="media">
                <div class="media-left">
                    <a href="">
                        <img class="media-object" src="" alt="" width="50px" height="50px" style="border-radius: 50%;padding: 3px;border: 2px solid #e8b563;">
                    </a>
                </div>
                <div class="media-body">

                    <a href="" style="text-decoration: none;color: #111;"><h4 class="media-heading" style="font-size: 14px;font-weight: bold;margin-top: 15px;">{{ $groups->nama_grup }}</h4>
                    </a>
                    <div id="" style="float: right;margin-top: -30px;">
                        {!! sHelper::grupButton($groups->id_grup, Auth::id(), '#people-listed-'.$groups->id_grup, 'btn-sm') !!}
                    </div>

                </div>
            </div>
        </div>
                    @endif
        @endforeach
    </div>
</div>