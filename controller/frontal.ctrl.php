<?php
	/**
	 * Created by PhpStorm.
	 * User: SMITHE
	 * Date: 17-Oct-16
	 * Time: 8:32
	 */

	/**
	 * Exemple pris: photoMatrixAction
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 *
	 *
	 * Exemple pris: zoomPhotoMatrix
	 * Les actions sont normalisées.
	 *        - Premiere partie obligatoirement en minuscule: Nom de l'action (Ici "zoom")
	 *        - Deuxième partie : Nom du controller associé (Ici "PhotoMatrix")
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

		// ----------------------------------------------------------------------------------------------User
		// TODO SessionManager
		case 'loginUser' :
			$controller->loginUserAction();
			break;

		case 'registerUser' :
			$controller->registerUserAction();
			break;

		// ----------------------------------------------------------------------------------------------Home
		default:
			$controller->homeAction();
			break;
	}
