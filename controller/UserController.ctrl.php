<?php
	use InputValidator\InputValidatorExceptions;

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 25/10/2016
	 *        Time: 20:34
	 */

	/**
	 * Exemple pris: photoMatrixAction
	 *
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 */

	/**
	 * Class UserController
	 *
	 * Contrôleur pour l'authentification utilisateur
	 */
	class UserController extends Controller {

		/**
		 * UserController constructor.
		 */
		public function __construct() {
			parent::__construct( 'UserDAO' );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue et traitement de la page de Connexion
		 */
		public function loginUserAction() {
			$this->makeMenu();
			$this->makeContent();

			// Si Données envoyé, traitement
			if ( !empty( $_POST ) ) {
				$inputValidator = new IValidatorVisu();

				try {
					// Récupération des données utilisateur validé
					$pswd   = htmlentities(
						$inputValidator->validateString( $_POST[ 'password' ] )
					);
					$pseudo = htmlentities(
						$inputValidator->validateString( $_POST[ 'pseudo' ] )
					);

					// Vérification des informations utilisateur dans la BDD
					$user       = $this->getDAO()->findUser( $pseudo );
					$verifyPswd = password_verify( $pswd, $user->getPassword() );

					if ( is_null( $user ) || !$verifyPswd )
						throw new InputValidatorExceptions(
							'Information de connexion inccorecte',
							'Le pseudo ou le mot de passe est incorrecte',
							TYPE_FEEDBACK_WARN
						);

					// Création d'une session utilisateur
					UserSessionManager::renew( $user );

					// Notification de succès et redirection vers le tableau de bord
					echo toAjax(
						TYPE_FEEDBACK_SUCCESS,
						[
							'Titre'   => 'Connexion réussie',
							'Message' => 'Vous êtes maintenant connecté !',
						],
						BASE_URL . PATH_TO_DASH
					);

				} catch ( InputValidatorExceptions $ive ) {
					// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
					echo ivExceptionToAjax( (object) $ive->getError() );
				}

				// Sinon si utilisateur déjà connecté, redirection vers le tableau de bord
			} elseif ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) )
				$this->redirectToRoute( PATH_TO_DASH );

			// Sinon génération de la page de connexion
			else
				$this->getViewManager()->render( 'User/loginUser' );
		}

		/**
		 * Met fin à la session utilisateur
		 */
		public function logoutUserAction() {
			UserSessionManager::close();
			$this->redirectToRoute();
		}

		/**
		 * Rendue et traitement de la page d'Inscription
		 */
		public function registerUserAction() {
			$this->makeMenu();
			$this->makeContent();

			// Si Données envoyé, traitement
			if ( !empty( $_POST ) ) {
				$inputValidator = new IValidatorVisu();

				try {
					// Récupération des données utilisateur validé
					$pswd        = htmlentities(
						$inputValidator->validateString( $_POST[ 'password' ] )
					);
					$confirmPswd = htmlentities(
						$inputValidator->validateString( $_POST[ 'confirmPassword' ] )
					);
					$pseudo      = htmlentities(
						$inputValidator->validateString( $_POST[ 'pseudo' ] )
					);

					// Vérification des données utilisateur
					$inputValidator->validateSameString( $pswd, $confirmPswd );

					// Insertion de l'utilisateur dans le BDD
					$user = new User( $pseudo, encrypt( $pswd ) );
					$this->getDAO()->addUser( $user );

					// Création d'une session utilisateur
					UserSessionManager::renew( $user );

					// Notification de succès et redirection vers le tableau de bord
					echo toAjax(
						TYPE_FEEDBACK_SUCCESS,
						[
							'Titre'   => 'Inscription réussite réussie',
							'Message' => 'Vous êtes maintenant connecté !',
						],
						BASE_URL . PATH_TO_DASH
					);

				} catch ( InputValidatorExceptions $ive ) {
					// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
					echo ivExceptionToAjax( (object) $ive->getError() );
				}

				// Sinon si utilisateur déjà connecté, redirection vers le tableau de bord
			} elseif ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) )
				$this->redirectToRoute( PATH_TO_DASH );

			// Sinon génération de la page d'inscription
			else
				$this->getViewManager()->render( 'User/registerUser' );
		}

		/**
		 * Action pour l'édition d'information utilisateur
		 *
		 * @throws \Exception
		 */
		public function editUserAction() {
			$this->makeMenu();
			$this->makeContent();

			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				// Si Données envoyé, traitement
				if ( !empty( $_POST ) ) {
					$iv = new IValidatorVisu();

					try {
						// Récupération des données utilisateur validé
						$pswd        = htmlentities(
							$iv->validateString( $_POST[ 'password' ] )
						);
						$confirmPswd = htmlentities(
							$iv->validateString( $_POST[ 'confirmPassword' ] )
						);
						$basePath    = User::BASE_PATH;

						// Si une URL est spécifié
						if ( isset( $_POST[ 'imageURL' ] ) && !empty( $_POST[ 'imageURL' ] ) )
							$path = $iv->validateURL( $_POST[ 'imageURL' ] );

						// Sinon upload un fichier local
						else {
							$file = $iv->moveFileUpload( $_FILES[ 'image' ], $basePath );
							$path = $file[ 'name' ];
						}

						// Vérification des données utilisateur
						$iv->validateSameString( $pswd, $confirmPswd );

						$user = new User(
							UserSessionManager::getSession()->getPseudo(), encrypt( $pswd )
						);
						$user->setAvatar( $path );

						$this->getDAO()->editUser( $user );

						UserSessionManager::renew( $user );

						// Notification de succès et redirection vers le tableau de bord
						echo toAjax(
							TYPE_FEEDBACK_SUCCESS,
							[
								'Titre'   => 'Modification réussite réussie',
								'Message' => 'Vos modification on bien été effectué !',
							],
							BASE_URL . PATH_TO_DASH
						);


					} catch ( InputValidatorExceptions $ive ) {
						// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
						echo ivExceptionToAjax( (object) $ive->getError() );
					}

					// Sinon génération de la page d'inscription
				} else
					$this->getViewManager()
					     ->setPageView( 'Dashboard/base' )
					     ->render( 'User/editUser' );

			} else
				$this->redirectToRoute( PATH_TO_DASH );
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


		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * Non nécessaire. Utilisé pour caster l'objet DAO en UserDAO pour l'IDE
		 *
		 * @return UserDAO
		 */
		protected function getDAO() {
			return parent::getDAO();
		}


	}