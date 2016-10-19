<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head >
	<title >Site SIL3</title >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="view/assets/css/style.css" media="screen" title="Normal" />
</head >
<body >
<?php
	require __DIR__ . '/../partials/header.partials.html';
	require __DIR__ . '/../partials/menu.partials.php';
?>

<div id="corps" >
	<p >
		<?php foreach ( $data->navbarContent as $text => $link ) : ?>
			<a href="<?= $link; ?>" ><?= $text; ?></a >
		<?php endforeach; ?>
		<!--<a href="<? /*= $data->prevImgLink; */ ?>" >Prev</a >
				<a href="<? /*= $data->nextImgLink; */ ?>" >Next</a >-->
	</p >


	<?php foreach ( $data->imgMatrixURL as $img ) : ?>
		<a href="<?= $img[ 1 ]; ?>" >
			<img src="<?= $img[ 0 ]; ?>" width="<?= $data->size; ?>" >
		</a >
	<?php endforeach; ?>

</div >

<?php
	require __DIR__ . '/../partials/footer.partials.html';
?>

</body >
</html >
