<?php
	require __DIR__ . '/../components/InputValidator/dist/InputValidator.php';
	use InputValidator\InputValidator;
	use \InputValidator\InputValidatorExceptions;

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 25/10/2016
	 *        Time: 20:34
	 */
	class UserController extends Controller {
		/**
		 * UserController constructor.
		 */
		public function __construct() {
			parent::__construct( 'UserDAO' );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		public function loginUserAction() {
			if ( !empty( $_POST ) ) {
				$inputValidator = new InputValidator();

				try {
					$pswd   = htmlentities(
						$inputValidator->validateString( $_POST[ 'password' ] )
					);
					$pseudo = htmlentities(
						$inputValidator->validateString( $_POST[ 'pseudo' ] )
					);

					$user       = $this->getDAO()->findUser( $pseudo );
					$verifyPswd = password_verify( $pswd, $user->getPassword() );

					if ( is_null( $user ) || !$verifyPswd )
						throw new InputValidatorExceptions(
							'Information de connexion inccorecte',
							'Le pseudo ou le mot de passe est incorrecte',
							TYPE_FEEDBACK_WARN
						);

					echo toAjax(
						TYPE_FEEDBACK_SUCCESS,
						[
							'Titre'   => 'Connexion réussie',
							'Message' => 'Vous êtes maintenant connecté !',
						],
						'./'
					);

				} catch ( InputValidatorExceptions $ive ) {
					echo ivExceptionToAjax( (object) $ive->getError() );
				}

			} else
				$this->renderView( __FUNCTION__ );
		}

		public function registerUserAction() {
			if ( !empty( $_POST ) ) {
				$inputValidator = new InputValidator();

				try {
					$pswd        = htmlentities(
						$inputValidator->validateString( $_POST[ 'password' ] )
					);
					$confirmPswd = htmlentities(
						$inputValidator->validateString( $_POST[ 'confirmPassword' ] )
					);
					$pseudo      = htmlentities(
						$inputValidator->validateString( $_POST[ 'pseudo' ] )
					);

					if ( $pswd !== $confirmPswd )
						throw new InputValidatorExceptions(
							'Mot de passe différents',
							'Les deux mots de passe saisis sont différents.',
							TYPE_FEEDBACK_WARN
						);

					$result = (Object) $this->getDAO()->addUser(
						new User( $pseudo, encrypt( $pswd ) )
					);

					if ( !$result->success )
						throw new InputValidatorExceptions(
							"Impossible d'ajouter l'utilisateur",
							$result->message,
							TYPE_FEEDBACK_DANGER
						);

					// TODO Redirection

				} catch ( InputValidatorExceptions $ive ) {
					echo ivExceptionToAjax( (object) $ive->getError() );
				}

			} else
				$this->renderView( __FUNCTION__ );
		}


		/**
		 *
		 */
		protected function makeContent() {
			// TODO: Implement makeContent() method.
		}


		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * @return UserDAO
		 */
		protected function getDAO() {
			return parent::getDAO();
		}


	}