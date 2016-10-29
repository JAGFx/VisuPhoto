<section class="row" >
	<h1 class="col-xs-12 text-center" >Matrice de photos</h1 >

	<nav aria-label="Page navigation" class="col-xs-12" >
		<ul class="pager" >
			<?php
				require __DIR__ . '/../Default/partials/subMenu.partials.php';
			?>
		</ul >
	</nav >
	<?php foreach ( $data->matrix as $imgInfo ) : ?>
		<div class="col-sm-6 col-md-4" >
			<div class="thumbnail" >
				<a href="<?= $imgInfo[ 1 ]; ?>" >
					<img src="<?= $imgInfo[ 0 ]->getPath(); ?>" alt="<?= $imgInfo[ 0 ]->getComment(
					); ?>" >
				</a >
				<div class="caption" >
					<h3 ><?= $imgInfo[ 0 ]->getComment(); ?></h3 >
					<p >
						<span class="label label-primary" >
							<?= $imgInfo[ 0 ]->getCategory(); ?>
						</span >
					</p >
				</div >
			</div >
		</div >
	<?php endforeach; ?>
</section >
