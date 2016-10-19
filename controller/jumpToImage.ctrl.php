<?php
	/**
	 * Created by PhpStorm.
	 * User: SMITHE
	 * Date: 06-Oct-16
	 * Time: 10:32
	 */

	// FIXME To Delete


	$imgID = ( isset( $_GET[ 'imgId' ] ) && !empty( $_GET[ 'imgId' ] ) )
		? $_GET[ 'imgId' ]
		: $imgDAO->getFirstImage()->getId();

	$nbJump = ( isset( $_GET[ 'nbJump' ] ) && !empty( $_GET[ 'nbJump' ] ) )
		? (int) $_GET[ 'nbJump' ]
		: 0;

	$nbImg = ( isset( $_GET[ 'nbImg' ] ) && !empty( $_GET[ 'nbImg' ] ) )
		? (int) $_GET[ 'nbImg' ]
		: MIN_NB_PIC;

	$size = ( isset( $_GET[ "size" ] ) )
		? $_GET[ "size" ]
		: MIN_WIDTH_PIC;

	$img = $imgDAO->jumpToImage( $imgDAO->getImage( $imgID ), $nbJump );

	header( "Location: " . BASE_URL . "viewPhotoMatrix&imgId=" . $img->getId() . "&size=$size&nbImg=$nbImg" );