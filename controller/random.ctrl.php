<?php
	/**
	 * Created by PhpStorm.
	 * User: SMITHE
	 * Date: 06-Oct-16
	 * Time: 10:26
	 */

	// FIXME To Delete

	// Débute l'acces aux images
	$imgDAO = new ImageDAO();

	$img   = $imgDAO->getRandomImage();
	$imgId = $img->getId();

	$size = ( isset( $_GET[ "size" ] ) )
		? $_GET[ "size" ]
		: MIN_WIDTH_PIC;

	header( "Location: " . BASE_URL . "viewPhoto&imgId=$imgId&size=$size" );