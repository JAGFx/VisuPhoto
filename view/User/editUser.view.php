<section class="row" >
	<h1 class="col-xs-12 page-header" >Edition de profil</h1 >

	<form method="POST" action="?a=editUser" data-preventDefault="yes" class="col-xs-12" >
		<div class="messageForm" ></div >

		<div class="form-group" >
			<label for="image" >Photo de profil</label >
			<div class="input-group" >
				<div class="input-group-addon" >
					<img class="img-circle" src="<?= UserSessionManager::getSession()->getAvatar(
					) ?>" height="20" alt="" >
				</div >
				<input type="file" name="image" class="form-control" id="image" accept="image/*" >
				<div class="input-group-addon" > - OU -</div >
				<input type="url" name="imageURL" class="form-control" id="imageURL" placeholder="URL : http://www.exemple.fr/image.png" >
			</div >
		</div >

		<div class="form-group" >
			<label for="email" >Mot de passe</label >
			<input type="password" class="form-control" name="password" id="password" placeholder="Ex: mot_2-PAsse" >
		</div >

		<div class="form-group" >
			<label for="confirmEmail" >Confirmation du mot de passe</label >
			<input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Ex: mot_2-PAsse" >
		</div >

		<button type="reset" class="btn btn-default" >Annuler</button >
		<button type="submit" class="btn btn-primary" >Modifer</button >
	</form >
</section >