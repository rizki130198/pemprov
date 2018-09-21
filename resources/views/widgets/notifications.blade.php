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
        <!-- Request Friend -->
        @else 
        @foreach(sHelper::notifications() as $notification)
        <a href="{{ $notification['url'] }}" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://st3.depositphotos.com/2703645/15661/v/450/depositphotos_156610906-stock-illustration-male-user-avatar-icon.jpg" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">{{ $notification['text'] }}</h5>
                        <span><i class="fa {{ $notification['icon'] }}" style="background: #5a90ff;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i></span>
                    </div>
                </div>
            </li>
        </a>
        @endforeach
        @endif
    </ul>
</li>