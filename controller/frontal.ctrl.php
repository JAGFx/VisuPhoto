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

	$action     = ( isset( $_GET[ 'a' ] ) ) ? htmlentities( $_GET[ 'a' ] ) : null;
	$controller = loadController( $action );

	switch ( $action ) {
		// ----------------------------------------------------------------------------------------------Photo
		case 'viewPhoto' :
			//require __DIR__ . '/PhotoController.ctrl.php';
			$controller->photoAction();
			break;

		// TODO Action for Photo solo

		// ----------------------------------------------------------------------------------------------Photo Matrix
		case 'viewPhotoMatrix' :
			//require __DIR__ . '/PhotoMatrixController.ctrl.php';
			//$photoMatrixCtrl = new PhotoMatrixController( $imgDAO );
			//$photoMatrixCtrl->viewPhotoMatrixAction();

			$controller->photoMatrixAction();
			break;

		case 'firstPhotoMatrix' :
			/*require __DIR__ . '/PhotoMatrixController.ctrl.php';
			$photoMatrixCtrl = new PhotoMatrixController( $imgDAO );*/
			//			$photoMatrixCtrl->firstPhotoMatrixAction();
			$controller->firstPhotoMatrixAction();
			break;

		case 'morePhotoMatrix' :
			/*require __DIR__ . '/PhotoMatrixController.ctrl.php';
			$photoMatrixCtrl = new PhotoMatrixController( $imgDAO );*/
			//			$photoMatrixCtrl->morePhotoMatrixAction();
			$controller->morePhotoMatrixAction();
			break;

		case 'lessPhotoMatrix' :
			/*require __DIR__ . '/PhotoMatrixController.ctrl.php';
			$photoMatrixCtrl = new PhotoMatrixController( $imgDAO );*/
			//			$photoMatrixCtrl->lessPhotoMatrixAction();
			$controller->lessPhotoMatrixAction();
			break;

		case 'prevPhotoMatrix':
			/*require __DIR__ . '/PhotoMatrixController.ctrl.php';
			$photoMatrixCtrl = new PhotoMatrixController( $imgDAO );*/
			//			$photoMatrixCtrl->prevPhotoMatrixAction();
			$controller->prevPhotoMatrixAction();
			break;

		case 'nextPhotoMatrix':
			/*require __DIR__ . '/PhotoMatrixController.ctrl.php';
			$photoMatrixCtrl = new PhotoMatrixController( $imgDAO );*/
			//			$photoMatrixCtrl->nextPhotoMatrixAction();
			$controller->nextPhotoMatrixAction();
			break;


		// ----------------------------------------------------------------------------------------------A Propos
		case 'viewAPropos' :
			//require __DIR__ . '/AProposController.ctrl.php';
			$controller->aProposAction();
			break;

		/*case 'zoomPhoto' :
			require __DIR__ . '/zoom.ctrl.php';
			break;

		case 'randomPhoto':
			require __DIR__ . '/random.ctrl.php';
			break;

		case 'jumpTo':
			require __DIR__ . '/jumpToImage.ctrl.php';
			break;*/

		// ----------------------------------------------------------------------------------------------Home
		default:
			//require __DIR__ . '/HomeController.ctrl.php';
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
