<!--FIXME Fail next & prev photo: Last never show -->
<?php foreach ( $data->navBar as $text => $link ) :
	if ( $text == 'Previous' ) : ?>
		<li class="previous" >
			<a href="<?= $link; ?>" ><span aria-hidden="true" >&larr;</span > <?= $text; ?>
			</a >
		</li >
		<?php
	elseif ( $text == 'Next' ) : ?>
		<li class="next" >
			<a href="<?= $link; ?>" ><?= $text; ?>
				<span aria-hidden="true" >&rarr;</span >
			</a >
		</li >
		<?php
	elseif ( $text == 'list' ) : ?>
		<li >
			<select name="selectList" onChange="window.location.href=this.value" >
				<option value="default" >Catégorie</option >
				<?php foreach ( $data->navBar[ 'list' ] as $list ) : ?>
					<option value="<?= $data->listCategoty; ?><?php echo $list->category; ?>" <?php echo ( $list->category == $data->currentCategory ) ? "selected" : ""; ?>><?php echo $list->category; ?> </option >
				<?php endforeach; ?>
			</select >
		</li >
	<?php else : ?>
		<li >
			<a href="<?= $link; ?>" ><?= $text; ?></span ></a >
		</li >
	<?php endif; ?>
<?php endforeach; ?>