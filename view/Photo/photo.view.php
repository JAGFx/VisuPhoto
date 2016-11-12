<section class="row" >
	<h1 class="col-xs-12 text-center" >Photo</h1 >

	<nav aria-label="Page navigation" class="col-xs-12" >
		<ul class="pager" >
			<?php
				require __DIR__ . '/../Default/partials/subMenu.partials.php';
			?>
		</ul >
	</nav >

	<div class="col-xs-12 col-md-8 col-md-offset-2" >
		<div class="thumbnail" >
			<a href="<?= $data->url; ?>" >
				<img src="<?= $data->img->getPath(); ?>" alt="<?= $data->img->getComment(
				); ?>" width="<?= $data->size; ?>" >
			</a >
			<div class="caption" >
				<h3 ><?= $data->img->getComment(); ?></h3 >
				<p >
					<span class="label label-primary" >
						<?= $data->img->getCategory(); ?>
					</span >
				</p >
				<p >
					<a href="<?php echo $data->modifier[ "Button" ]; ?>" class="btn btn-primary btn-sm" >
						Modifier
					</a >

					<a href="<?php echo $data->note[ "Dislike" ]; ?>" class="btn btn-danger btn-sm" >
						Dislike
						<span class="badge" ><?= $data->note[ "infoNote" ]->Dislike ?></span >
					</a >
					<a href="<?php echo $data->note[ "Like" ]; ?>" class="btn btn-success btn-sm" >
						Like <span class="badge" ><?= $data->note[ "infoNote" ]->Like ?></span >
					</a ><br />
				</p >
			</div >
		</div >
	</div >
</section >
