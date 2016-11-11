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
		 * @var Album
		 */
		private $_album;

		/**
		 * AlbumController constructor.
		 */
		public function __construct() {
			parent::__construct( 'AlbumDAO' );

			// Récupération de l'image actuel si défini
			$album = ( isset( $_GET[ "albumID" ] ) )
				? $this->getDAO()->findAlbumById( htmlentities( $_GET[ "albumID" ] ) )
				: null;

			$this->setAlbum( $album );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		public function viewAlbum() {
			// Ajout des valeurs de vues communes
			$this->makeMenu();
			$this->makeContent();

			// Ajout de l'album et affichge de la vue
			$this->getViewManager()
			     ->setValue( 'listAlbum', $this->_album )
			     ->render( 'Album/viewAlbum' );
		}

		/**
		 * Permet de visualiser la liste des albums dans le dashboard de l'utilisateur
		 */
		public function viewListAlbumAction() {
			// Accessible que si utilisateur connecté
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				// Ajout des valeurs de vues communes
				$this->makeMenu();
				$this->makeContent();


				$listAlbum = $this->getDAO()->findListAlbumByUser(
					UserSessionManager::getSession()
				);

				// Affichge dashboard et rendu de la vue
				$this->getViewManager()
				     ->setPageView( 'Dashboard/base' )
				     ->setValue( 'listAlbum', $listAlbum )
				     ->render( 'Album/listAlbum' );

			} else
				$this->redirectToRoute( 'loginUser' );
		}

		/**
		 * Methode pour créer un album si l'utilisateur est connecté
		 * Affiche en retour succès ou echec avec la fonction toAjax
		 */
		public function addAlbumAction() {
			// Accessible que si utilisateur connecté
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {

				// Si envoie de données faire ....
				if ( !empty( $_POST ) ) {
					$iv = new IValidatorVisu();

					try {
						// Récupération des données utilisateur
						$name    = $iv->validateString( $_POST[ 'name' ] );
						$listImg = $iv->validateString( $_POST[ 'listImg' ] );

						// Ajout en base de donnée
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

					// Sinon afficher la vue
				} else {
					// Ajout des valeurs de vues communes
					$this->makeMenu();
					$this->makeContent();

					// Ajout des données supplémentaires
					$photoDAO = loadDAO( 'ImageDAO' );
					$listImg  = $photoDAO->getFullImageList();

					// Affichage dashboard et rendu
					$this->getViewManager()
					     ->setValue( 'listImg', $listImg )
					     ->setPageView( 'Dashboard/base' )
					     ->render( 'Album/addAlbum' );
				}

			} else
				$this->redirectToRoute( 'loginUser' );
		}


		/**
		 * Methode pour éditer un album déjà créé
		 */
		public function editAlbumAction() {
			// Accessible que si utilisateur connecté
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				// Si envoie de données faire ....
				if ( !empty( $_POST ) ) {
					$iv = new IValidatorVisu();

					try {
						// Récupération des données utilisateur
						$name    = $iv->validateString( $_POST[ 'name' ] );
						$listImg = $iv->validateString( $_POST[ 'listImg' ] );

						// Modification de l'album
						$this->getAlbum()->setName( $name );
						$this->getAlbum()->emptyImage();

						$imgDAO = loadDAO( 'ImageDAO' );

						foreach ( explode( ',', $listImg ) as $imgID )
							$this->getAlbum()->addImage( $imgDAO->getImage( $imgID ) );

						// Mise à jour
						$this->getDAO()->editAlbum( $this->getAlbum() );

						// Notification de succès et redirection vers le tableau de bord
						echo toAjax(
							TYPE_FEEDBACK_SUCCESS,
							[
								'Titre'   => 'Edition réussie',
								'Message' => "La modification de l'album à été effectué avec succès",
							]
						);

					} catch ( InputValidatorExceptions $ive ) {
						// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
						echo ivExceptionToAjax( (object) $ive->getError() );
					}

					// Sinon afficher la vue
				} else {
					// Ajout des valeurs de vues communes
					$this->makeMenu();
					$this->makeContent();

					// Ajout des données supplémentaires
					$photoDAO = loadDAO( 'ImageDAO' );
					$listImg  = $photoDAO->getFullImageList();

					// Affichage dashboard et rendu
					$this->getViewManager()
					     ->setPageView( 'Dashboard/base' )
					     ->setValue( 'listImg', $listImg )
					     ->setValue( 'albumToEdit', $this->getAlbum() )
					     ->render( 'Album/editAlbum' );
				}

			} else
				$this->redirectToRoute( 'loginUser' );
		}

		/**
		 * Suppression d'un album par un utilisateur
		 */
		public function removeAlbumAction() {
			// Accessible que si utilisateur connecté
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				try {
					// Suppression de l'album
					$this->getDAO()->removeAlbum( $this->getAlbum() );
					$this->redirectToRoute( 'viewlistAlbum' );

				} catch ( InputValidatorExceptions $ive ) {
					// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
					echo ivExceptionToAjax( (object) $ive->getError() );
				}

			} else
				$this->redirectToRoute( 'loginUser' );
		}

		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() { }

		/**
		 * Génération des données du menu
		 * Méthode factorisé à tous les Contrôleur. Indique les menu minimaux
		 */
		protected function makeMenu() {
			parent::makeMenu();

			$this->getViewManager()->setValue(
				'menuAdmin',
				[
					'Connexion'   => BASE_URL . "loginUser",
					'Inscription' => BASE_URL . "registerUser"
				]
			);
		}

		/**
		 * @return AlbumDAO|null
		 */
		protected function getDAO() {
			return parent::getDAO(); // TODO: Change the autogenerated stub
		}

		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * @return Album
		 */
		public function &getAlbum() {
			return $this->_album;
		}

		/**
		 * @param Album $album
		 */
		public function setAlbum( &$album ) {
			$this->_album = ( isset( $album ) && !empty( $album ) )
				? $album
				: null;
		}
	}
