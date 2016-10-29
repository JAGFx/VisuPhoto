<!DOCTYPE html>
<html lang="fr" >
	<head >
		<meta charset="utf-8" >
		<meta http-equiv="X-UA-Compatible" content="IE=edge" >
		<meta name="viewport" content="width=device-width, initial-scale=1" >
		<meta name="description" content="" >
		<meta name="author" content="" >
		<title >Dashboard Template for Bootstrap</title >

		<link rel="stylesheet" type="text/css" href="view/Default/assets/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="view/Default/assets/lib/font-awesome-4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="view/Default/assets/lib/formsJS/formJS.css" />
		<link rel="stylesheet" type="text/css" href="view/Default/assets/css/ie10-viewport-bug-workaround.css" />
		<link rel="stylesheet" type="text/css" href="view/Default/assets/css/dashboard.css" media="screen" title="Normal" />
	</head >

	<body >
		<nav class="navbar navbar-inverse navbar-fixed-top" >
			<div class="container-fluid" >
				<div class="navbar-header" >
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" >
						<span class="sr-only" >Toggle navigation</span >
						<span class="icon-bar" ></span >
						<span class="icon-bar" ></span >
						<span class="icon-bar" ></span >
					</button >
					<a class="navbar-brand" href="./" >VisuPhoto</a >
				</div >
				<div id="navbar" class="navbar-collapse collapse" >
					<ul class="nav navbar-nav navbar-right" >
						<?php foreach ( $data->menu as $item => $act ) : ?>
							<li ><a href="<?= $act ?>" ><?= $item ?></a ></li >
						<?php endforeach; ?>
					</ul >
				</div >
			</div >
		</nav >

		<div class="container-fluid" >
			<div class="row" >
				<div class="col-sm-3 col-md-2 sidebar" >
					<ul class="nav nav-sidebar" >
						<li class="active" ><a href="#" >Overview
								<span class="sr-only" >(current)</span ></a ></li >
						<li ><a href="#" >Reports</a ></li >
						<li ><a href="#" >Analytics</a ></li >
						<li ><a href="#" >Export</a ></li >
					</ul >
					<ul class="nav nav-sidebar" >
						<li ><a href="" >Nav item</a ></li >
						<li ><a href="" >Nav item again</a ></li >
						<li ><a href="" >One more nav</a ></li >
						<li ><a href="" >Another nav item</a ></li >
						<li ><a href="" >More navigation</a ></li >
					</ul >
					<ul class="nav nav-sidebar" >
						<li ><a href="" >Nav item again</a ></li >
						<li ><a href="" >One more nav</a ></li >
						<li ><a href="" >Another nav item</a ></li >
					</ul >
				</div >
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" >
					<div class="row" >
						<?php
							require $data->view;
						?>
					</div >
				</div >
			</div >
		</div >

		<script src="view/Default/assets/lib/jquery-3.1.1/jquery-3.1.1.min.js" ></script >
		<script src="view/Default/assets/lib/bootstrap-3.3.7-dist/js/bootstrap.min.js" ></script >
		<script src="view/Default/assets/lib/formsJS/forms.js" ></script >
		<script src="view/Default/assets/js/ie10-viewport-bug-workaround.js" ></script >

		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js" ></script >
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" ></script >
		<![endif]-->
	</body >
</html >
