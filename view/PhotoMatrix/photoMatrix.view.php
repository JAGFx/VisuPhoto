<p >
	<?php foreach ( $data->navBar as $text => $link ) : ?>
		<a href="<?= $link; ?>" ><?= $text; ?></a >
	<?php endforeach; ?>
	<!--<a href="<? /*= $data->prevImgLink; */ ?>" >Prev</a >
				<a href="<? /*= $data->nextImgLink; */ ?>" >Next</a >-->
</p >


<?php foreach ( $data->matrix as $img ) : ?>
	<a href="<?= $img[ 1 ]; ?>" >
		<img src="<?= $img[ 0 ]; ?>" width="<?= $data->size; ?>" >
	</a >
<?php endforeach; ?>