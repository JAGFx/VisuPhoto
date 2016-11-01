<?php
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 22/10/2016
	 * Time: 10:40
	 */

	// ----------------------------------------------------------------------------------------------Constants
	define( 'BASE_URL', '?a=' );
define('LIKE_BUTTON', 1);
define('DISLIKE_BUTTON', 0);
	define( 'MORE_RATIO', 1.25 );
	define( 'LESS_RATIO', 0.75 );
	define( 'MIN_WIDTH_PIC', 480 );
	define( 'MIN_NB_PIC', 1 );

	define( 'ERR_INVALID_DAO_NAME', 'Nom de DAO invalide ou introuvable' );
	define( 'ERR_INVALID_CTRL_NAME', 'Nom de Controlêur invalide ou introuvable' );
	define( 'ERR_INVALID_VIEW_NAME', 'Nom de la Vue invalide ou introuvable' );

	define( 'TYPE_FEEDBACK_SUCCESS', -1 );
	define( 'TYPE_FEEDBACK_INFO', 1 );
	define( 'TYPE_FEEDBACK_WARN', 2 );
	define( 'TYPE_FEEDBACK_DANGER', 3 );
	define( 'TYPE_FEEDBACK_ERROR', 4 );

	define( 'PATH_TO_DASH', 'homeDashboard' );

	// ----------------------------------------------------------------------------------------------Functions

	/**
	 * Renvoie un JSON pour l'AJAX
	 *
	 * @param  string $typeFeedback Le type de retour : "danger", "warning" ou "success"
	 * @param  array  $data         un tableau des données qui seront affichées
	 *                              array("Titre" => "Erreur", "Message" => "")
	 * @param  string $url          Url de redirection
	 *
	 * @return string       le JSON
	 */
	function toAjax( $typeFeedback, $data, $url = null ) {
		//var_dump($typeFeedback);

		$type = [
			TYPE_FEEDBACK_SUCCESS => 'success',
			TYPE_FEEDBACK_INFO    => 'info',
			TYPE_FEEDBACK_WARN    => 'warning',
			TYPE_FEEDBACK_DANGER  => 'danger',
			TYPE_FEEDBACK_ERROR   => 'error'
		];

		return json_encode(
			[
				"Type" => $type[ $typeFeedback ],
				"Data" => $data,
				"Url"  => $url
			]
		);
	}

	/**
	 * Prépare le retour d'erreur InputValidatorException en JSON
	 *
	 * @param object $error Information de l'erreur  de l'exception
	 *
	 * @return string JSON
	 */
	function ivExceptionToAjax( $error ) {
		return toAjax(
			$error->code,
			[
				'Titre'   => $error->title,
				'Message' => $error->message
			]
		);
	}

	/**
	 * Importe et crée un objet Controller correspondant à l'$action
	 *
	 * @param string $action
	 *
	 * @return Controller
	 * @throws Exception
	 */
	function loadController( $action ) {
		/*
		 * Exemple pris: zoomPhotoMatrix
		 * Les actions sont normalisées.
		 * 	- Première partie obligatoirement en minuscule: Nom de l'action (Ici "zoom")
		 * 	- Deuxième partie : Nom du controller associé (Ici "PhotoMatrix")
		 */
		preg_match( '/^[a-z]+(\w+)$/', htmlentities( $action ), $matches );

		// Récupération du contrôleur ou "Home" si pas de correspondance
		$ctrl = ( ( empty( $matches[ 0 ] ) ) ? 'Home' : $matches[ 1 ] ) . 'Controller';

		// Chargement du contrôleur
		$path = __DIR__ . '/' . $ctrl . '.ctrl.php';

		if ( !is_file( $path ) )
			throw new Exception( ERR_INVALID_CTRL_NAME );

		require_once __DIR__ . '/../model/Controller.class.php';
		require_once $path;

		// Création et retour du contrôleur
		return new  $ctrl();
	}

	/**
	 * Charge un DAO spécifique
	 *
	 * @param string $name
	 *
	 * @return DAO
	 * @throws Exception
	 */
	function loadDAO( $name ) {
		$path = __DIR__ . '/../model/DAO/' . $name . '.dao.php';

		if ( !is_file( $path ) )
			throw new Exception( ERR_INVALID_DAO_NAME . ' : ' . $name );

		require_once $path;

		return new $name();
	}

	/**
	 * Crypte les mots de passes
	 *
	 * @param  String $data les données à crypter
	 *
	 * @return String       les données cryptées
	 */
	function encrypt( $data ) {
		return password_hash(
			$data,
			PASSWORD_DEFAULT,
			[ 'salt' => mcrypt_create_iv( 22, MCRYPT_DEV_URANDOM ) ]
		);
	}
