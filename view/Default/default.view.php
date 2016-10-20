<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head >
		<title >Site SIL3</title >
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="view/Default/assets/css/style.css" media="screen" title="Normal" />
	</head >
	<body >
		<?php
			require __DIR__ . '/../Default/partials/header.partials.html';
			require __DIR__ . '/../Default/partials/menu.partials.php';
		?>

		<div id="corps" >
			<?php
				require $data->view;
			?>
		</div >

		<?php
			require __DIR__ . '/../Default/partials/footer.partials.html';
		?>

	</body >
</html >
