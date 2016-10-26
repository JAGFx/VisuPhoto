<?php
	/**
	 * Created by PhpStorm.
	 * User: SMITHE
	 * Date: 17-Oct-16
	 * Time: 8:32
	 */
	session_start();

	require __DIR__ . '/../model/DAO.class.php';
	require __DIR__ . '/commons.php';

	$action = ( isset( $_GET[ 'a' ] ) ) ? htmlentities( $_GET[ 'a' ] ) : null;

	$controller = loadController( $action );

	switch ( $action ) {
		// ----------------------------------------------------------------------------------------------Photo
		case 'viewPhoto' :
			$controller->photoAction();
			break;

		case 'firstPhoto':
			$controller->firstPhotoAction();
			break;

		case 'randomPhoto':
			$controller->randomPhotoAction();
			break;

		case 'zoommorePhoto':
			$controller->zoommorePhotoAction();
			break;

		case 'zoomlessPhoto':
			$controller->zoomlessPhotoAction();
			break;

		case 'prevPhoto':
			$controller->prevPhotoAction();
			break;

		case 'nextPhoto':
			$controller->nextPhotoAction();
			break;


		// ----------------------------------------------------------------------------------------------Photo Matrix
		case 'viewPhotoMatrix' :
			$controller->photoMatrixAction();
			break;

		case 'firstPhotoMatrix' :
			$controller->firstPhotoMatrixAction();
			break;

		case 'randomPhotoMatrix' :
			$controller->randomPhotoMatrixAction();
			break;

		case 'morePhotoMatrix' :
			$controller->morePhotoMatrixAction();
			break;

		case 'lessPhotoMatrix' :
			$controller->lessPhotoMatrixAction();
			break;

		case 'prevPhotoMatrix':
			$controller->prevPhotoMatrixAction();
			break;

		case 'nextPhotoMatrix':
			$controller->nextPhotoMatrixAction();
			break;

		case 'filtrebycategoryPhotoMatrix':
			$controller->filtreByCategoryAction();
			break;


		// ----------------------------------------------------------------------------------------------A Propos
		case 'viewAPropos' :
			$controller->aProposAction();
			break;

		// ----------------------------------------------------------------------------------------------Home
		default:
			$controller->homeAction();
			break;
	}
