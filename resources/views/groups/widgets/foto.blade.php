<div class="panel panel-default">
  <div class="panel-heading" style="background-color: #f5f6f7;background:none; "><h3 style="margin-top: 0;"><strong>Foto</strong><span style="color: #90949c;"> {{$images_grup->count()}}</span></h3></div>
  <div class="panel-body">
    <div class="col-md-12">
      <div class="row">
        @foreach($images_grup as $rowImage)
        <?php $image = explode(',',$rowImage->image_path); ?>
        @for($i = 0; $i < count($image); $i++) 
        <img style="display: inline-block;margin-right: 3px;margin-bottom: 10px;" src="{{ url('storage/uploads/posts/'.$image[$i]) }}" width="133px" height="133px">
        @endfor
        @endforeach
      </div>
    </div>
  </div>
</div>