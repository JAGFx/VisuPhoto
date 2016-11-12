<section class="col-xs-12" >
	<div class="tab-content" >
		<div role="tabpanel" class="tab-pane active" id="infoUser" >
			<section class="row" id="head" >
				<p class="text-center" >
					<img src="<?= UserSessionManager::getSession()->getAvatar(
					) ?>" width="150" height="150" class="img-circle" >
				</p >
				<h2 class="text-center text-capitalize light" ><?= UserSessionManager::getSession(
					)->getPseudo() ?></h2 >
				<p class="text-center" >
					<a href="<?= BASE_URL . 'editUser' ?>" class="btn btn-sm btn-default-o" >Editer</a >
				</p >
			</section >
			<section class="row" >
				<h1 class="col-xs-12  page-header" >Votes</h1 >

				<table class="table table-striped col-xs-12" >
					<tr >
						<th >Image</th >
						<th >Commentaire</th >
						<th >Catégorie</th >
						<th >Vote</th >
					</tr >
					<?php foreach ( $data->listVote as $vote ) : ?>
						<tr >
							<td >
								<img src="<?= Image::BASE_PATH . $vote->path; ?>" height="30" alt="" >
							</td >
							<td ><?= $vote->comment; ?></td >
							<td >
								<span class="label label-primary" ><?= $vote->category; ?></span >
							</td >
							<td >
								<?php if ( $vote->valueJug ) : ?>
									<span class="glyphicon glyphicon-thumbs-up votePos" ></span >
								<?php else : ?>
									<span class="glyphicon glyphicon-thumbs-down voteNeg" ></span >
								<?php endif; ?>
							</td >
						</tr >
					<?php endforeach; ?>
				</table >
			</section >
		</div >
	</div >
</section >