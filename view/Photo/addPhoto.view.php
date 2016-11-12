<section class="row" >
	<h1 class="col-xs-12 page-header" >Image > Ajouter</h1 >

	<form method="POST" action="?a=addPhoto" data-preventDefault="yes" class="col-xs-12" >
		<div class="messageForm" ></div >

		<div class="form-group" >
			<label for="image" >Image</label >
			<div class="input-group" >
				<input type="file" name="image" class="form-control" id="image" accept="image/*" >
				<div class="input-group-addon" > - OU -</div >
				<input type="url" name="imageURL" class="form-control" id="imageURL" placeholder="URL : http://www.exemple.fr/image.png" >
			</div >
		</div >

		<div class="form-group" >
			<label for="category" >Catégorie</label >
			<select name="category" class="form-control" id="category" required >
				<?php foreach ( $data->listeCtge as $list ) : ?>
					<option value="<?php echo $list[ 0 ]; ?>" ><?php echo $list[ 0 ]; ?> </option >
				<?php endforeach; ?>
			</select >
		</div >

		<div class="form-group" >
			<label for="comment" >Commentaire</label >
			<input type="text" class="form-control" name="comment" id="comment" placeholder="Ex: Prairie" required >
		</div >

		<button type="reset" class="btn btn-default" >Annuler</button >
		<button type="submit" class="btn btn-primary" >Envoyer</button >
	</form >
</section >