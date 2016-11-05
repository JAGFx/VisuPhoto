<nav class="navbar navbar-inverse navbar-fixed-top" >
	<div class="container" >
		<div class="navbar-header" >
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" >
				<span class="sr-only" >Toggle navigation</span >
				<span class="icon-bar" ></span >
				<span class="icon-bar" ></span >
				<span class="icon-bar" ></span >
			</button >
			<a class="navbar-brand" href="./" >VisuPhoto</a >
		</div >
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
			<ul class="nav navbar-nav navbar-right" >
				<?php foreach ( $data->menu as $item => $act ) : ?>
					<li ><a href="<?= $act ?>" ><?= $item ?></a ></li >
				<?php endforeach; ?>

				<?php if ( UserSessionManager::getSession()->getPrivilege(
					) <= UserSessionManager::NO_PRIVILEGE
				) : ?>
					<?php foreach ( $data->menuAdmin as $item => $act ) : ?>
						<li ><a href="<?= $act ?>" ><?= $item ?></a ></li >
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) : ?>
					<li class="dropdown user active" >
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
							<img src="view/Default/assets/pics/nouser.png" width="30" height="30" class="img-circle" > <?= UserSessionManager::getSession(
							)->getPseudo() ?> <span class="caret" ></span >
						</a >
						<ul class="dropdown-menu" >
							<li >
								<a href="<?= BASE_URL . PATH_TO_DASH ?>" >Dashboard</a >
							</li >
							<li role="separator" class="divider" ></li >
							<li >
								<a href="<?= BASE_URL . 'logoutUser' ?>" >Déconnexion</a >
							</li >
						</ul >
					</li >
				<?php endif; ?>
			</ul >
		</div >
	</div >
</nav >