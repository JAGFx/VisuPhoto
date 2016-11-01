<section class="row" >
	<h1 class="col-xs-12 page-header" >Album > Liste</h1 >

	<table class="table table-striped col-xs-12" >
		<tr >
			<th >#</th >
			<th >Nom</th >
			<th >Nombre d'image</th >
			<th >Action</th >
		</tr >
		<?php foreach ( $data->listImgUser as $album ) : ?>
			<tr >
				<td ><?= $album->getId(); ?></td >
				<td ><?= $album->getName(); ?></td >
				<td ><?= count( $album->getImages() ); ?></td >
				<td >
					<a class="btn btn-xs btn-primary" href="<?= BASE_URL . 'editionDashboard&e=Album&i=' . $album->getId(
					); ?>" >Modifier</a >
				</td >
			</tr >
		<?php endforeach; ?>
	</table >
</section >