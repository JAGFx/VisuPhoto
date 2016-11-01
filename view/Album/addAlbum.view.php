<section class="row" >
	<h1 class="col-xs-12 page-header" >Album > Ajouter</h1 >

	<form method="POST" action="?a=addAlbum" data-preventDefault="yes" class="col-xs-12" >
		<div class="messageForm" ></div >

		<div class="form-group" >
			<label for="name" >Nom</label >
			<input type="text" class="form-control" name="name" id="name" placeholder="Ex: Paysage" required >
		</div >

		<div class="control-group" >
			<label for="listImg" >Liste image</label >
			<input type="text" class="selectizeListImg" name="listImg" id="listImg" placeholder="Ex: Paysage" required list="images" >
			<datalist id="images" >
				<?php foreach ( $data->listImg as $list ) : ?>
					<option value="<?php echo $list->getId(
					); ?>" label="<?php echo $list->getComment() . ' [ ' . $list->getCategory(
						) . ' ]'; ?>" ><?= $list->getPath(); ?></option >
				<?php endforeach; ?>
			</datalist >
		</div >

		<button type="reset" class="btn btn-default" >Annuler</button >
		<button type="submit" class="btn btn-primary" >Envoyer</button >
	</form >
</section >