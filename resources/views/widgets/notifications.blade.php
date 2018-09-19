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
        <!-- Group Like -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="http://icons-for-free.com/free-icons/png/512/318585.png" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">menyukai kiriman anda di </span><span>Depok Sempit </span></h5>
                        <span><i class="fa fa-thumbs-up" style="background: #5a90ff;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!--  Kiriman Group -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://upload.wikimedia.org/wikipedia/commons/3/38/Wikipedia_User-ICON_byNightsight.png" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">mengirimkan sesuatu di </span><span>Depok Sempit </span></h5>
                        <span><i class="fa fa-users" style="background: #e17e41;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!--  Comment Group -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://upload.wikimedia.org/wikipedia/commons/3/38/Wikipedia_User-ICON_byNightsight.png" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">mengomentari kiriman anda di </span><span>Depok Sempit </span></h5>
                        <span><i class="fa fa-comments" style="background: #fac959;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!-- Like Post -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://st3.depositphotos.com/2703645/15661/v/450/depositphotos_156610906-stock-illustration-male-user-avatar-icon.jpg" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">menyukai kiriman anda </span></h5>
                        <span><i class="fa fa-thumbs-up" style="background: #5a90ff;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!-- Comment Post -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://st3.depositphotos.com/2703645/15661/v/450/depositphotos_156610906-stock-illustration-male-user-avatar-icon.jpg" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">mengomentari kiriman anda </span></h5>
                        <span><i class="fa fa-comments" style="background: #fac959;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!-- Add Event -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://st3.depositphotos.com/2703645/15661/v/450/depositphotos_156610906-stock-illustration-male-user-avatar-icon.jpg" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">menambahkan acara </span><span style="font-weight: 100;">pada tanggal <strong>13-10-2018</strong>.</span></h5>
                        <span><i class="fa fa-calendar" style="background: #abc554;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!-- Comment Event -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://st3.depositphotos.com/2703645/15661/v/450/depositphotos_156610906-stock-illustration-male-user-avatar-icon.jpg" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">mengomentari kiriman anda di Acara </span></h5>
                        <span><i class="fa fa-comments" style="background: #fac959;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        <!-- Request Friend -->
        <a href="" style="color: #555">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" width="48" height="48" src="https://st3.depositphotos.com/2703645/15661/v/450/depositphotos_156610906-stock-illustration-male-user-avatar-icon.jpg" alt="">
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading" style="font-weight: bold;">Rizki <span style="font-weight: 100;">mulai mengikuti anda </span></h5>
                        <span><i class="fa fa-user" style="background: #5a90ff;color:#fff;padding: 4px;font-size: 12px;border-radius: 50px;"></i> 2h</span>
                    </div>
                </div>
            </li>
        </a>

        @else
        @foreach(sHelper::notifications() as $notification)
        <li>
            <a href="{{ $notification['url'] }}">
                <i class="fa {{ $notification['icon'] }}"></i> {{ $notification['text'] }}
            </a>
        </li>
        @endforeach
        @endif
    </ul>
</li>