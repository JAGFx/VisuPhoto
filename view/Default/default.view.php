<!DOCTYPE html>
<html lang="fr" >
	<head >
		<title >Site SIL3</title >
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" >

		<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="assets/lib/font-awesome-4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="assets/lib/formsJS/formJS.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen" title="Normal" />
	</head >
	<body class="container-fluid" >
		<?php
			require __DIR__ . '/../Default/partials/header.partials.php';
		?>
		<section class="container" >
			<?php
				require $data->view;
			?>
		</section >
		<?php

			require __DIR__ . '/../Default/partials/footer.partials.php';
		?>
	</body >
	<script src="assets/lib/jquery-3.1.1/jquery-3.1.1.min.js" ></script >
	<script src="assets/lib/bootstrap-3.3.7-dist/js/bootstrap.min.js" ></script >
	<script src="assets/lib/formsJS/forms.js" ></script >
</html >
