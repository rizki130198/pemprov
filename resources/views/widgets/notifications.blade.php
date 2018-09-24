<li class="dropdown direct-messages-notification">
    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown" role="button" aria-expanded="false">
        <i class="fa fa-commenting"></i>
    </a>
</li>
<li class="dropdown notifications">
    <a href="#" class="dropdown-toggle parent" data-toggle="dropdown" role="button" aria-expanded="false">
        @if(count(sHelper::notifications()) > 0)
        <span class="badge badge-notify">{{ count(sHelper::notifications()) }}</span>
        @endif
        <i class="fa fa-bell"></i>
    </a>

    <ul class="dropdown-menu list-group inner-container" role="menu">
        @if(count(sHelper::notifications()) == 0)
        <li class="list-group-item" style="padding: 10px;border-radius: 0;">
            <a href="javascript:;">Tidak Ada Pemberitahuan.</a>
        </li>

        @else
        @foreach(sHelper::notifications() as $notification)
        <a href="{{ $notification['url'] }}" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <!-- <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://upload.wikimedia.org/wikipedia/commons/3/38/Wikipedia_User-ICON_byNightsight.png" alt="">
                    </div> -->
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">{{ $notification['nama'] }} <span style="font-weight: 100;">{{ $notification['text'] }} </span><span>{{ $notification['grup'] }} </span></h5>
                        <span><i class="fa {{ $notification['icon'] }} {{ $notification['color'] }}"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>
        </li>
        @endforeach
        @endif
    </ul>
</li>