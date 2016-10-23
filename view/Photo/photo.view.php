<section class="row" >
	<nav aria-label="Page navigation" class="col-xs-12" >
		<ul class="pager" >

			<li class="previous" >
				<a href="<?= $data->navBar[ 'previous' ]; ?>" ><span aria-hidden="true" >&larr;</span > Previous</a >
			</li >
			<li class="next" ><a href="<?= $data->navBar[ 'next' ]; ?>" >Next
					<span aria-hidden="true" >&rarr;</span ></a ></li >
		</ul >
	</nav >

	<h1 class="col-xs-12" ><?= $data->img->getComment(); ?></h1 >
	<p class="col-xs-12" >
		<span class="label label-primary" ><?= $data->img->getCategory(); ?></span >
	</p >
	<!--<p >
	<?php /*foreach ( $data->navBar as $text => $link ) : */ ?>
		<a href="<? /*= $link; */ ?>" ><? /*= $text; */ ?></a >
	<?php /*endforeach; */ ?>
	<!--<a href="<? /* /*= $data->prevImgLink; */ ?>" >Prev</a >
				<a href="<? /* /*= $data->nextImgLink; */ ?>" >Next</a >
</p >-->

	<a href="<?= $data->url; ?>" class="col-xs-12" >
		<img src="<?= $data->img->getPath(); ?>" width="<?= $data->size; ?>" class="img-rounded" >
	</a >

</section >
