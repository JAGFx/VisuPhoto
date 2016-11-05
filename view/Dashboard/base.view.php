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
		<link rel="stylesheet" type="text/css" href="view/Default/assets/lib/selectize.js-master/dist/css/selectize.css" >
		<link rel="stylesheet" type="text/css" href="view/Default/assets/lib/selectize.js-master/dist/css/selectize.default.css" >
	</head >

	<body >
		<?php
			require __DIR__ . '/../Default/partials/menu.partials.php';
		?>

		<div class="container-fluid" >
			<div class="row" >
				<?php
					require __DIR__ . '/partials/menu.partials.php';
				?>
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
		<script src="view/Default/assets/js/script.js" ></script >
		<script src="view/Default/assets/lib/jquery-ui-1.12.1.custom/jquery-ui.min.js" ></script >
		<script src="view/Default/assets/lib/selectize.js-master/dist/js/selectize.min.js" ></script >

		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js" ></script >
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" ></script >
		<![endif]-->
	</body >
</html >
