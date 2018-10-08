@extends('layouts.app')

@section('content')
<style type="text/css">
    .group-badge{
        background-color: rgba(0, 0, 0, 0.2);   
    }

    .group-box{
        padding: 10px 20px;
        border-left:none;
        overflow: hidden;
        margin-top: -50px;
        padding-top: -100px;
        border-radius: 17px;
        background-color: #fff;
        margin-top: 25px;
        color:#555;
        box-shadow: 2px 2px 2px 2px #E0E0E0;
        
    }

    .group-mark{
        font-weight: bold;
        font-size:60px;
        color:#555;
    }

    .group-text{        
        font-size: 19px;
        margin-top: -10px;
    }
    .group-text span{
        color: #e44d3a;
    }
</style>
<div class="h-20"></div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">


            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#posts">Postingan ({{ $posts->count() }})</a></li>
                <li><a data-toggle="pill" href="#users">Pengguna ({{ $users->count() }})</a></li>
                <!-- <li><a data-toggle="pill" href="#grup">Grup ({{ $grup->count() }})</a></li> -->
            </ul>

            <div class="tab-content">
                <div id="posts" class="tab-pane fade in active">


                    @if($posts->count() == 0)


                    <div class="alert-message alert-message-default">
                        <h4>Tidak Di Temukan !</h4>
                    </div>


                    @else
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            @foreach($posts as $post)

                            @include('widgets.post_detail.single_post')

                            @endforeach
                        </div>
                    </div>
                    @endif


                </div>
                <div id="users" class="tab-pane fade">

                    @if($users->count() == 0)


                    <div class="alert-message alert-message-default">
                        <h4>Tidak Di Temukan !</h4>
                    </div>


                    @else
                    <div class="m-t-20"></div>
                    <div class="row">
                        @foreach($users as $user_p)

                        <div class="col-sm-6 col-md-4">
                            <div class="card-container">
                                <div class="card">
                                    <div class="front">
                                        <div class="cover" style="background-image: url('{{ $user_p->getCover() }}')"></div>
                                        <div class="user">
                                            <a href="{{ url('/'.$user_p->username) }}">
                                                <img class="img-circle @if($user_p->sex == 1){{ 'female' }}@endif" src="{{ $user_p->getPhoto(130, 130) }}"/>
                                            </a>
                                        </div>
                                        <div class="content" style="padding-bottom: 20px">
                                            <div class="main">
                                                <a href="{{ url('/'.$user_p->username) }}">
                                                    <h3 class="name">{{ $user_p->name }}</h3>
                                                    <p class="profession">
                                                        {{ '@'.$user_p->username }}
                                                        @if($user_p->canSeeProfile(Auth::id()))
                                                        <small>{{ Auth::user()->distance($user_p) }}</small>
                                                        @else
                                                        <small>(Private)</small>
                                                        @endif
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                    @endif


                </div>
<!--                 <div id="grup" class="tab-pane fade">

                    @if($grup->count() == 0)


                    <div class="alert-message alert-message-default">
                        <h4>Tidak Di Temukan !</h4>
                    </div>


                    @else
                    <div class="m-t-20"></div>
                    <div class="row">
                       @foreach($grup as $group)
                       <div class="col-sm-6 col-md-4">
                        <a href="{{ url('/group/diskusi/'.$group->id_grup) }}">
                            <div class="panel group-box">
                                <p class="quotation-mark">
                                </p>
                                <p class="group-mark">
                                    <i class="fa fa-users"></i>
                                </p>
                                <p class="group-text">
                                    Nama grup : <span>{{ $group->nama_grup }}</span> 
                                </p>
                                <hr>
                                <div class="blog-post-actions">
                                    <p class="blog-post-bottom pull-left">
                                       {{ $group->name }}
                                   </p>
                                   <p class="blog-post-bottom pull-right">
                                      <!-- <span class="badge quote-badge">{{count( $group->id_groups)}}</span>  <i class="fa fa-user"></i> -->
                                  </p>
                              </div>
                          </div>
                      </a>
                  </div>
                  @endforeach
              </div>
              @endif


          </div> -->
      </div>

  </div>
</div>
</div>
@endsection

@section('footer')
@endsection