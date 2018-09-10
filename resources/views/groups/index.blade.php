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
        width: 325px;
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
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3" style="padding-left: 0;position: fixed;">
            @include('widgets.sidebar')
        </div>

        <div class="col-md-8 col-md-offset-3 col-xs-12">
            <div class="content-page-title">
                <i class="fa fa-users"></i> Groups
                @if(Auth::user()->role=='admin')
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Buat Group</button>
                </div>
                @endif
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Buat Grup</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="javascript:void(0);" id="grupcreate" method="post" accept-charset="utf-8">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="inputGrup">Nama Grup</label>
                                    <input type="text" name="nama_grup" class="form-control" id="inputGrup" placeholder="Nama Grup">
                                </div>
                               <!--  <div class="form-group">
                                    <label for="gambar">Cover Image</label>
                                    <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Cover Grup">
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($groups->count() == 0)

            <div class="alert-message alert-message-default">
                <h4>Belum ada group</h4>
            </div>

            @else 
            <div class="row">
                @foreach($groups->get() as $group)
                <div class="col-sm-6 col-md-4">
                    <a href="{{ url('/group/diskusi/'.$group->id_grup) }}">
                        <div class="panel group-box">
                            <p class="quotation-mark">
                            </p>
                            <p class="group-mark">
                                <i class="fa fa-users"></i>
                            </p>
                            <p class="group-text">
                                Nama group : <span>{{ $group->nama_grup }}</span> 
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
        </div>
    </div>
</div>

@endsection

@section('footer')

@endsection