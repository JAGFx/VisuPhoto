<section class="row" >
	<?php if ( empty( $data->albumToEdit ) ): ?>
		<div class="alert alert-cust-error" role="alert" >
			<div class="ico" >
				<span class="glyphicon glyphicon-fire" ></span >
			</div >
			<div class="info" >
				<h4 >Album inconu !</h4 >
				<p >Le numéro de l'album n'est pas dans la base de donnée</p >
			</div >
		</div >

	<?php else : ?>

		<h1 class="col-xs-12 page-header" >Album > Modifier > <?= $data->albumToEdit->getName(); ?>
			<!--<span class="label label-primary" ><? /*= $data->albumToEdit->getCategory(); */ ?></span >--></h1 >

		<form method="POST" action="?a=editAlbum&albumID=<?= $data->albumToEdit->getId(
		); ?>" data-preventDefault="yes" class="col-xs-12" >
			<div class="messageForm" ></div >

			<div class="form-group" >
				<label for="name" >Nom</label >
				<input type="text" class="form-control" name="name" id="name" placeholder="Ex: Paysage" required
					value="<?= $data->albumToEdit->getName(); ?>" >
			</div >

			<div class="control-group" >
				<label for="listImg" >Liste image</label >
				<input type="text" class="selectizeListImg" name="listImg" id="listImg" placeholder="Ex: Paysage" required list="images"
					value="<?= $data->albumToEdit->getImageString(); ?>" >
				<datalist id="images" >
					<?php foreach ( $data->listImg as $list ) : ?>
						<option value="<?php echo $list->getId(
						); ?>" label="<?php echo $list->getComment(
							) . ' [ ' . $list->getCategory(
							) . ' ]'; ?>" ><?= $list->getPath(); ?></option >
					<?php endforeach; ?>
				</datalist >
			</div >

			<button type="reset" class="btn btn-default" >Annuler</button >
			<button type="submit" class="btn btn-primary" >Modifier</button >
		</form >
	<?php endif; ?>
</section >