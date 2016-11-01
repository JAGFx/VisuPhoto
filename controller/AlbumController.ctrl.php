<?php
	use InputValidator\InputValidatorExceptions;

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 31/10/2016
	 *        Time: 18:01
	 */
	class AlbumController extends Controller {
		/**
		 * AlbumController constructor.
		 */
		public function __construct() {
			parent::__construct( 'AlbumDAO' );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		public function addAlbumAction() {
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE )
			     && !empty( $_POST )
			) {
				$iv = new IValidatorVisu();

				try {
					$name    = $iv->validateString( $_POST[ 'name' ] );
					$listImg = $iv->validateString( $_POST[ 'listImg' ] );

					$album  = new Album( null, $name, UserSessionManager::getSession() );
					$imgDAO = loadDAO( 'ImageDAO' );

					foreach ( explode( ',', $listImg ) as $imgID )
						$album->addImage( $imgDAO->getImage( $imgID ) );

					$this->getDAO()->addAlbum( $album );

					// Notification de succès et redirection vers le tableau de bord
					echo toAjax(
						TYPE_FEEDBACK_SUCCESS,
						[
							'Titre'   => 'Ajout réussie',
							'Message' => "L'ajout de l'album à été effectué avec succès",
						]
					);

				} catch ( InputValidatorExceptions $ive ) {
					// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
					echo ivExceptionToAjax( (object) $ive->getError() );
				}
			}
		}

		public function editAlbumAction() {
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE )
			     && !empty( $_POST )
			) {
				$iv = new IValidatorVisu();

				try {
					$id      = (int) $iv->validateString( $_POST[ 'id' ] );
					$name    = $iv->validateString( $_POST[ 'name' ] );
					$listImg = $iv->validateString( $_POST[ 'listImg' ] );

					$album  = new Album( $id, $name, UserSessionManager::getSession() );
					$imgDAO = loadDAO( 'ImageDAO' );

					foreach ( explode( ',', $listImg ) as $imgID )
						$album->addImage( $imgDAO->getImage( $imgID ) );

					$this->getDAO()->editAlbum( $album );

					// Notification de succès et redirection vers le tableau de bord
					echo toAjax(
						TYPE_FEEDBACK_SUCCESS,
						[
							'Titre'   => 'Ajout réussie',
							'Message' => "L'ajout de l'album à été effectué avec succès",
						]
					);

				} catch ( InputValidatorExceptions $ive ) {
					// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
					echo ivExceptionToAjax( (object) $ive->getError() );
				}
			}
		}

		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() {
			// TODO: Implement makeContent() method.
		}
	}