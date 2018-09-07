<style type="text/css">
@media (max-width: 768px){
	.panel-pengaturan{
		margin-bottom: 50px;
		border-radius: 0;
	}
}
</style>
<div class="panel panel-default">
	<form method="POST" action="{{ url('/group/edit/'.$group->id_grup) }}">
	<div class="panel-body">
		<div class="col-md-12">
			<div class="row">
				<label>Nama Grup</label>
				<input type="text" name="nama_grup" placeholder="Nama Grup">
				<br>
				<br>
				<label>Privasi Grup</label>
				<select class="form-control" style="border: none;background-color: #f1f1f1;height: 45px;box-shadow: none;border-radius: 0;">
					<option>Public</option>
					<option>Tertutup</option>
					<option>Rahasia</option>
				</select>
				<br>
				<label>Menghapus grup akan menghilangkan semua data, anda tidak akan bisa melihat grup ini kembali.</label>
				<button class="btn btn-danger">Hapus Grup</button>
			</div>
		</div>
	</div>
	<div class="panel-footer" style="background-color: #f5f6f7;background:none; ">
		<button type="submit" class="btn btn-success btn-block">Update</button>
	</div>
	</form>
</div>