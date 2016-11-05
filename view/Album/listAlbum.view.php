<section class="row" >
	<h1 class="col-xs-12 page-header" >Album > Liste</h1 >

	<table class="table table-striped col-xs-12" >
		<tr >
			<th >#</th >
			<th >Nom</th >
			<th >Nombre d'image</th >
			<th >Action</th >
		</tr >
		<?php foreach ( $data->listAlbum as $album ) : ?>
			<tr >
				<td ><?= $album->getId(); ?></td >
				<td ><?= $album->getName(); ?></td >
				<td ><?= count( $album->getImages() ); ?></td >
				<td >
					<a class="btn btn-xs btn-primary" href="<?= BASE_URL . 'editAlbum&albumID=' . $album->getId(
					); ?>" >Modifier</a >
					<a class="btn btn-xs btn-primary" href="<?= BASE_URL . 'removeAlbum&albumID=' . $album->getId(
					); ?>" >Supprimer</a >
				</td >
			</tr >
		<?php endforeach; ?>
	</table >
</section >