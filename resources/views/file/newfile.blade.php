<h3 style="margin:0;">Files <small>({{$file->count()}})</small></h3>
<p style="width: 100%;border-bottom: dashed 2px #d1d1d1;padding-top: 15px;"></p>
<div class="row">
	@foreach($file as $data)
	<?php 
	$hasil = explode(',', $data->jenis_file);
	$filenya = explode(',', $data->filenya);
	$encrypt = explode(',', $data->encrypt);
	for ($i=0; $i < count($hasil) ; $i++) {  ?>
		<a href="{{url('/downloads/files/'.$encrypt[$i])}}">
			<div class="col-md-2 col-xs-4"> 
				<center><div class="icon icon_type_file icon_ext_{{$hasil[$i]}}">{{$hasil[$i]}}</div></center>
				<p align="center" style="color: #555;">{{$filenya[$i]}}</p>
			</div>
		</a>
	<?php } ?>
	@endforeach
</div>  