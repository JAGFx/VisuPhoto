<div id="menu" >
	<h3 >Menu</h3 >
	<ul >
		<?php foreach ( $data->menu as $item => $act ) : ?>
			<li ><a href="<?= $act ?>" ><?= $item ?></a ></li >
		<?php endforeach; ?>
	</ul >
</div >