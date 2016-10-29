<nav class="navbar navbar-default navbar-inverse" >
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
			<ul class="nav navbar-nav" >
				<?php foreach ( $data->menu as $item => $act ) : ?>
					<li ><a href="<?= $act ?>" ><?= $item ?></a ></li >
				<?php endforeach; ?>
			</ul >
		</div >
	</div >
</nav >