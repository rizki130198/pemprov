@extends('layouts.app')

@section('content')
<div class="h-20"></div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3" style="padding-left: 0;position: fixed;">
            @include('widgets.sidebar')
        </div>
        <div class="col-md-8 col-md-offset-3 col-xs-12">
            <div class="content-page-title">
                <i class="fa fa-users"></i> Groups
            </div>
            @if($groups->count() == 0)

            <div class="alert-message alert-message-default">
                <h4>Belum ada group</h4>
            </div>
            @if(Auth::user()->role == 'admin')
            <div class="alert-message alert-message-default">
                <button class="btn btn-prmary">Buat Group</button>
            </div>
            @endif

            @else

            <div class="row">
                @foreach($groups->get() as $group)
                <div class="col-sm-6 col-md-4">
                    <a class="bs-box" href="{{ url('/group/'.$group->id_grup) }}">
                        <h3>{{ $group->nama_grup }}</h3>
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