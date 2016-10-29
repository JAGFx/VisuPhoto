<section class="row" >
	<h1 class="col-xs-12 text-center" >Matrice de photos</h1 >

	<nav aria-label="Page navigation" class="col-xs-12" >
		<ul class="pager" >

			<li class="previous" >
				<a href="<?= $data->navBar[ 'previous' ]; ?>" ><span aria-hidden="true" >&larr;</span > Previous</a >
			</li >

			<li  >
				<a href="<?= $data->navBar[ 'First' ]; ?>" >First <span aria-hidden="true" ></span ></a >
			</li >

			<li  >
				<a href="<?= $data->navBar[ 'Random' ]; ?>" >Random <span aria-hidden="true" ></span ></a >
			</li >

			<li  >
				<a href="<?= $data->navBar[ 'More' ]; ?>" >More <span aria-hidden="true" ></span ></a >
			</li >

			<li  >
				<a href="<?= $data->navBar[ 'Less' ]; ?>" >Less <span aria-hidden="true" ></span ></a >
			</li >

			<li  >
			<select name="selectList" onChange="window.location.href=this.value"> 
			<option value = "default">Selectionner une categorie </option>
			<?php foreach ($data->navBar[ 'list' ] as $list) { ?>
					<option value = "<?= $data->listCategoty[ 'list' ]; ?><?php echo $list[0]; ?>"><?php echo $list[0];?> </option>
					
				<?php } ; ?>
				</select>
			
			</li >
			<li class="next" >
				<a href="<?= $data->navBar[ 'next' ]; ?>" >Next <span aria-hidden="true" >&rarr;</span ></a >
			</li >
		</ul >
	</nav >

	

	<?php foreach ( $data->matrix as $imgInfo ) : ?>


		<div class="col-sm-6 col-md-4" >
			<div class="thumbnail" >
				<a href="<?= $imgInfo[ 1 ]; ?>" >
					<img src="<?= $imgInfo[ 0 ]->getPath(); ?>"  >
				</a >
				<div class="caption" >
					<h3 ><?= $imgInfo[ 0 ]->getComment(); ?></h3 >
					<p >
						<span class="label label-primary" >
							<?= $imgInfo[ 0 ]->getCategory(); ?>
						</span >
					</p >
				</div >
			</div >
		</div >
	<?php endforeach; ?>
</section >