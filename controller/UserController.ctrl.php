<?php
	require __DIR__ . '/../components/InputValidator/dist/InputValidator.php';
	use InputValidator\InputValidator;
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
			// Si Données envoyé, traitement
			if ( !empty( $_POST ) ) {
				$inputValidator = new InputValidator();

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
				$this->renderView( __FUNCTION__ );
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
			// Si Données envoyé, traitement
			if ( !empty( $_POST ) ) {
				$inputValidator = new InputValidator();

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
					if ( $pswd !== $confirmPswd )
						throw new InputValidatorExceptions(
							'Mot de passe différents',
							'Les deux mots de passe saisis sont différents.',
							TYPE_FEEDBACK_WARN
						);

					// Insertion de l'utilisateur dans le BDD
					$user   = new User( $pseudo, encrypt( $pswd ) );
					$result = (Object) $this->getDAO()->addUser( $user );

					if ( !$result->success )
						throw new InputValidatorExceptions(
							"Impossible d'ajouter l'utilisateur",
							$result->message,
							TYPE_FEEDBACK_DANGER
						);

					// Création d'une session utilisateur
					UserSessionManager::start( $user );

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
				$this->renderView( __FUNCTION__ );
		}


		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() { }


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