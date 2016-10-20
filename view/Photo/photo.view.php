<p >
	<?php foreach ( $data->navBar as $text => $link ) : ?>
		<a href="<?= $link; ?>" ><?= $text; ?></a >
	<?php endforeach; ?>
	<!--<a href="<? /*= $data->prevImgLink; */ ?>" >Prev</a >
				<a href="<? /*= $data->nextImgLink; */ ?>" >Next</a >-->
</p >

<a href="<?= $data->matrix[ 1 ]; ?>" >
	<img src="<?= $data->matrix[ 0 ]; ?>" width="<?= $data->size; ?>" >
</a >
