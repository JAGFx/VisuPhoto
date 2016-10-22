<?php
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 22/10/2016
	 * Time: 10:40
	 */

	// ----------------------------------------------------------------------------------------------Constants
	define( 'BASE_URL', '?a=' );
	define( 'MORE_RATIO', 1.25 );
	define( 'LESS_RATIO', 0.75 );
	define( 'MIN_WIDTH_PIC', 480 );
	define( 'MIN_NB_PIC', 1 );


	// ----------------------------------------------------------------------------------------------Functions

	/**
	 * Importe et crée un objet Controller correspondant à l'$action
	 *
	 * @param $action
	 * @param $dao
	 *
	 * @return Controller
	 */
	function loadController( $action, $dao ) {
		/*
		 * Exempe pris: zoomPhotoMatrix
		 * Les actions sont normalisées.
		 * 	- Premiere partie obligatoirement en minuscule: Nom de l'action (Ici "zoom")
		 * 	- Deuxième partie : Nom du controller associé (Ici "PhotoMatrix")
		 */
		preg_match( '/^[a-z]+(\w+)$/', htmlentities( $action ), $matches );

		// Recupération du contrôleur ou "Home" si pas de correspondance
		$ctrl = ( ( empty( $matches[ 0 ] ) ) ? 'Home' : $matches[ 1 ] ) . 'Controller';

		// Chargement du contrôleur
		$path = __DIR__ . '/' . $ctrl . '.ctrl.php';

		require __DIR__ . '/../model/Controller.class.php';
		require $path;

		// Création et retour du contrôleur
		return new  $ctrl( $dao );
	}
