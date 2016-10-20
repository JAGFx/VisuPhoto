<?php
	/**
	 * Created by PhpStorm.
	 * User: SMITHE
	 * Date: 17-Oct-16
	 * Time: 8:32
	 */

	require __DIR__ . '/../model/imageDAO.php';

	define( 'BASE_URL', '?a=' );
	define( 'MORE_RATIO', 1.25 );
	define( 'LESS_RATIO', 0.75 );
	define( 'MIN_WIDTH_PIC', 480 );
	define( 'MIN_NB_PIC', 1 );

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


	/**
	 * @param $action
	 *
	 * @return Controller
	 */
	function loadController( $action ) {
		preg_match( '/^[a-z]+(\w+)$/', htmlentities( $action ), $matches );

		$ctrl = ( ( empty( $matches[ 0 ] ) ) ? 'Home' : $matches[ 1 ] ) . 'Controller';
		$path = __DIR__ . '/' . $ctrl . '.ctrl.php';

		require __DIR__ . '/Controller.class.php';
		require $path;

		$imgDAO = new ImageDAO();

		return new  $ctrl( $imgDAO );
	}
