<style type="text/css">
.clearfix:after, .panel .panel-element .element-content .content-post:after, .panel .panel-element .element-actions:after {
	content: '';
	display: table;
	clear: both;
}

.animate, .panel .panel-element .element-content, .panel .panel-element .element-content .btn-more, .panel .panel-element .element-actions .btn-action, .panel .panel-element .element-actions .btn-action > i {
	transition: all 0.2s;
}

/* General */
button {
	display: block;
	background: transparent;
	border: 0;
	cursor: pointer;
}

h1 {
	display: block;
	background-color: #fff;
	width: 100%;
	line-height: 1;
	margin-bottom: 20px;
	padding: 65px 50px;
	font-weight: 700;
	font-size: 32px;
	color: #6F6F6F;
}
.panel .panel-element {
	position: relative;
	z-index: 1;
}
.panel .panel-element .element-content {
	padding: 15px;
	border-bottom: 1px solid #d6d6d6;
	position: relative;
	right: 0;
}
.panel .panel-element .element-content .btn-more {
	width: 30px;
	height: 30px;
	line-height: 30px;
	opacity: 0;
	position: absolute;
	top: 0;
	right: 0;
}
.panel .panel-element .element-content .btn-more > i {
	font-size: 16px;
	color: #929292;
	vertical-align: middle;
}
.panel .panel-element .element-content .btn-more .icon-open,
.panel .panel-element .element-content .btn-more .icon-hearted {
	display: none;
}
.panel .panel-element .element-content .btn-more:hover {
	background-color: #F9F9F9;
}
.panel .panel-element .element-content .content-post .post-avatar {  
	float: left;
}
.panel .panel-element .element-content .content-post .post-content {
	margin-left: 75px;
	padding-top: 9px;
}
.panel .panel-element .element-content .content-post .post-content .post-title,
.panel .panel-element .element-content .content-post .post-content .post-body {
	display: block;
}
.panel .panel-element .element-content .content-post .post-content .post-title {
	font-size: 14px;
	color: #656464;
}
.panel .panel-element .element-content .content-post .post-content .post-body {
	margin-top: 5px;
	font-size: 12px;
	color: #a9a7a7;
}
.panel .panel-element .element-content:hover .btn-more {
	opacity: 1;
}
.panel .panel-element .element-actions {
	/*width: 100px;*/
	height: 45px;
	font-size: 0;
	position: absolute;
	top: 50%;
	right: 20px;
	z-index: 1;
	-webkit-transform: translateY(-50%);
	transform: translateY(-50%);
}
.panel .panel-element .element-actions .btn-action {
	display: inline-block;
	width: 45px;
	height: 45px;
	border-width: 2px;
	border-style: solid;
	border-radius: 50%;
}
.panel .panel-element .element-actions .btn-action > i {
	font-size: 20px;
}
.panel .panel-element .element-actions .btn-action.btn-hide {
	border-color: #34495e;
}
.panel .panel-element .element-actions .btn-action.btn-hide > i {
	color: #34495e;
}
.panel .panel-element .element-actions .btn-action.btn-hide:hover {
	background-color: #34495e;
}
.panel .panel-element .element-actions .btn-action.btn-heart {
	border-color: #e74c3c;
}
.panel .panel-element .element-actions .btn-action.btn-heart > i {
	color: #e74c3c;
}
.panel .panel-element .element-actions .btn-action.btn-heart:hover {
	background-color: #e74c3c;
}
.panel .panel-element .element-actions .btn-action:not(:last-child) {
	margin-right: 10px;
}
.panel .panel-element .element-actions .btn-action:hover > i {
	color: #fff;
}
.panel .panel-element:not(:first-child) {
	margin-top: 15px;
}
.panel .panel-element.panel-element-open .element-content {
	right: 84px;
}
.panel .panel-element.panel-element-open .element-content .btn-more {
	opacity: 1;
}
.panel .panel-element.panel-element-open .element-content .btn-more .icon-closed {
	display: none;
}
.panel .panel-element.panel-element-open .element-content .btn-more .icon-open {
	display: inline-block;
}
.panel .panel-element.panel-element-hearted .element-actions .btn-action.btn-heart {
	background-color: #e74c3c;
}
.panel .panel-element.panel-element-hearted .element-actions .btn-action.btn-heart > i {
	color: #fff;
}
.panel .panel-element.panel-element-hearted .element-content .btn-more {
	opacity: 1;
}
.panel .panel-element.panel-element-hearted .element-content .btn-more > i {
	color: #e74c3c;
}
.panel .panel-element.panel-element-hearted .element-content .btn-more .icon-open,
.panel .panel-element.panel-element-hearted .element-content .btn-more .icon-closed {
	display: none;
}
.panel .panel-element.panel-element-hearted .element-content .btn-more .icon-hearted {
	display: inline-block;
}

@media screen and (max-width: 768px) {
	h1 {
		margin-bottom: 0;
		padding: 40px;
		font-size: 25px;
	}

	.panel-default{
		border: none;
		border-radius: 0;
		margin-bottom: 48px;
	}

	.panel .panel-element .element-content .btn-more {
		opacity: 1;
	}
	.panel .panel-element .element-content .btn-more:hover {
		background-color: transparent;
	}
	.col-anggota{
		width: 100% !important;
	}
}
</style>
<div class="panel panel-default">
	<div class="panel-heading" style="background-color: #f5f6f7;background:none; "><h3 style="margin-top: 0;"><strong>Anggota</strong><span style="color: #90949c;"> {{$anggota->count()}}</span></h3></div>
	<div class="panel-body">
		@foreach($myuser as $myuser)
		<div class="col-md-12" style="margin-bottom: 20px;">
			<div class="panel-element">
				<div class="element-content">
					<button class="btn btn-more dropdown-toggle" id="editAnggota" data-toggle="dropdown" aria-expanded="true">
						<i class="fa fa-ellipsis-h"></i>
					</button>
					<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="editAnggota" style="top: 33px;">
						<li role="presentation"><a role="menuitem" href="javascript:;" onclick="keluargrup('{{$myuser->id_user}}','{{$myuser->id_groups}}')" >Keluar dari Grup</a></li>
					</ul>
					<div class="content-post">
						@if($myuser->profile_path!=NULL)								
						<div class="post-avatar">
							<img class="img-circle" src="{{ url('storage/uploads/profile_photos/'.$myuser->profile_path) }}" width="60px" height="60px">
						</div>
						@else
						<div class="post-avatar">
							<img class="img-circle" src="{{ url('images/profile-picture.png') }}" width="60px" height="60px">
						</div>
						@endif
						<div class="post-content">
							<span class="post-title">{{ $myuser->name }}</span>
							<p class="post-body">{{ '@'.$myuser->username }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
		<div class="col-md-12" style="margin-bottom: 20px;">
			<div class="row">
				<h4 style="padding: 0 0 0 15px;margin-bottom: 0;font-weight: bold;margin-top: 0;">Admin</h4>
				@foreach($admin as $admin)
				<div class="col-md-6 col-anggota" style="width: 50%;">
					<div class="panel-element">
						<div class="element-content">
							@if($cekanggota->jabatan_grup=='admin')
							<button class="btn btn-more dropdown-toggle" id="editAnggota" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-ellipsis-h"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="editAnggota" style="top: 33px;">
								<li role="presentation"><a role="menuitem" href="javascript:;"onclick="hapusadminanggota('{{$admin->id_user}}','{{$admin->id_groups}}')" >Hapus Status Admin</a></li>
							</ul>
							@endif
							<div class="content-post">
								@if($admin->profile_path!=NULL)								
								<div class="post-avatar">
									<img class="img-circle" src="{{ url('storage/uploads/profile_photos/'.$admin->profile_path) }}" width="60px" height="60px">
								</div>
								@else
								<div class="post-avatar">
									<img class="img-circle" src="{{ url('images/profile-picture.png') }}" width="60px" height="60px">
								</div>
								@endif
								<div class="post-content">
									<span class="post-title">{{ $admin->name }}</span>
									<p class="post-body">{{ '@'.$admin->username }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<h4 style="padding: 0 0 0 15px;margin-bottom: 0;font-weight: bold;margin-top: 0;">Semua Anggota</h4>
				@foreach($anggota as $member)
				<div class="col-md-6 col-anggota" style="width: 50%;">
					<div class="panel-element">
						<div class="element-content">
							@if($cekanggota->jabatan_grup=='admin')
							<button class="btn btn-more dropdown-toggle" id="editAnggota" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-ellipsis-h"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="editAnggota" style="top: 33px;">
								@if ($member->jabatan_grup!='admin')
								<li role="presentation" style="margin-bottom: 3px;"><a role="menuitem" href="javascript:;" onclick="createdadmin('{{$member->id_user}}','{{$member->id_groups}}')">Jadikan admin Grup</a></li>
								<li role="presentation"><a role="menuitem" href="javascript:;"onclick="kickanggota('{{$member->id_user}}','{{$member->id_groups}}')" >Hapus Anggota</a></li>
								@else
								<li role="presentation"><a role="menuitem" href="javascript:;"onclick="hapusadminanggota('{{$member->id_user}}','{{$member->id_groups}}')" >Hapus Status Admin</a></li>
								@endif

							</ul>
							@endif
							<div class="content-post">
								@if($member->profile_path!=NULL)								
								<div class="post-avatar">
									<img class="img-circle" src="{{ url('storage/uploads/profile_photos/'.$member->profile_path) }}" width="60px" height="60px">
								</div>
								@else
								<div class="post-avatar">
									<img class="img-circle" src="{{ url('images/profile-picture.png') }}" width="60px" height="60px">
								</div>
								@endif
								<div class="post-content">
									<span class="post-title">{{ $member->name }}</span>
									<p class="post-body">{{ '@'.$member->username }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>