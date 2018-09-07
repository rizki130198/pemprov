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

@media screen and (max-width: 500px) {
	h1 {
		margin-bottom: 0;
		padding: 40px;
		font-size: 25px;
	}

	.panel .panel-element .element-content .btn-more {
		opacity: 1;
	}
	.panel .panel-element .element-content .btn-more:hover {
		background-color: transparent;
	}
}
</style>
<div class="panel panel-default">
	<div class="panel-heading" style="background-color: #f5f6f7;background:none; "><h3 style="margin-top: 0;"><strong>Anggota</strong><span style="color: #90949c;"> {{$anggota->count()}}</span></h3></div>
	<div class="panel-body">
		<div class="col-md-12">
			<div class="row">
				@foreach($anggota as $member)
				<div class="col-md-6">
					<div class="panel-element">
						<div class="element-content">
							<button class="btn btn-more dropdown-toggle" id="editAnggota" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-ellipsis-h"></i>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="editAnggota" style="left: 144px;top: 33px;">
							    <li role="presentation" style="margin-bottom: 3px;"><a role="menuitem" href="#">Jadikan admin Grup</a></li>
							    <li role="presentation"><a role="menuitem" href="#">Hapus Anggota</a></li>
							</ul>
							<div class="content-post">
								<div class="post-avatar">
									<img class="img-circle" src="{{ url('storage/uploads/profile_photos/'.$member->profile_path) }}" width="60px" height="60px">
								</div>

								<div class="post-content">
									<span class="post-title">{{ $user->name }}</span>
									<p class="post-body">{{ '@'.$user->username }}</p>
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