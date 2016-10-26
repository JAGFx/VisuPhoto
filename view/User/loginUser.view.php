<section class="row" >
	<h1 class="col-xs-12 text-center" >Connexion</h1 >

	<form method="POST" action="?a=loginUser" data-preventDefault="yes" class="col-xs-12" >
		<div class="messageForm" ></div >

		<div class="form-group" >
			<label for="pseudo" >Pseudo</label >
			<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo" >
		</div >

		<div class="form-group" >
			<label for="email" >Mot de passe</label >
			<input type="password" class="form-control" name="password" id="password" placeholder="Ex: mot_2-PAsse" >
		</div >

		<button type="reset" class="btn btn-default" >Annuler</button >
		<button type="submit" class="btn btn-primary" >Connexion</button >
	</form >
</section >