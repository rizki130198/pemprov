<div class="panel panel-default">
  <div class="panel-heading" style="background-color: #f5f6f7;background:none; "><h3 style="margin-top: 0;"><strong>Foto</strong><span style="color: #90949c;"> {{$images_grup->count()}}</span></h3></div>
  <div class="panel-body">
    <div class="col-md-12">
      <div class="row">
        @foreach($images_grup->slice(0,3) as $rowImage)
        <img style="display: inline-block;margin-right: 3px;margin-bottom: 10px;" src="{{ url('storage/uploads/posts/'.$rowImage->image_path) }}" width="133px" height="133px">
        @endforeach
      </div>
    </div>
  </div>
</div>