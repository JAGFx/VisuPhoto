<section class="row" >
	<h1 class="col-xs-12 page-header" >Album > Liste</h1 >

	<table class="table table-striped col-xs-12" >
		<tr >
			<th >Nom</th >
			<th >Action</th >
		</tr >
		<?php foreach ( $data->listCategory as $list ) : ?>

			<tr >
				<td ><?php echo $list->category ?></td >
				<td >
					<a class="btn btn-xs btn-primary" href="<?= BASE_URL . 'deleteCategory&catName=' . $list->category; ?>" >Supprimer</a >
				</td >
			</tr >
		<?php endforeach; ?>
	</table >
</section >