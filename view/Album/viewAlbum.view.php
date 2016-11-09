<section class="row" >
	<h1 class="col-xs-12 text-center" ><?= $data->listAlbum->getName() ?></h1 >

	<?php foreach ( $data->listAlbum->getImages() as $imgInfo ) : ?>
		<div class="col-sm-6 col-md-4" >
			<div class="thumbnail" >
				<a href="<?= BASE_URL . 'viewPhoto&imgId=' . $imgInfo->getId(); ?>" >
					<img src="<?= $imgInfo->getPath(); ?>" alt="<?= $imgInfo->getComment(); ?>" >
				</a >
				<div class="caption" >
					<h3 ><?= $imgInfo->getComment(); ?></h3 >
					<p >
						<span class="label label-primary" >
							<?= $imgInfo->getCategory(); ?>
						</span >
					</p >
				</div >
			</div >
		</div >
	<?php endforeach; ?>
</section >
