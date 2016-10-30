<?php

	require_once __DIR__ . '/../User.class.php';
	use InputValidator\InputValidatorExceptions;

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 25/10/2016
	 *        Time: 19:54
	 */

	/**
	 * Class UserDAO
	 */
	class UserDAO extends DAO {

		/**
		 * Ajoute un utilisateur dans la BDD
		 *
		 * @param User $user
		 *
		 * @throws InputValidatorExceptions
		 */
		public function addUser( User $user ) {
			$query  = 'INSERT INTO user VALUES(?, ?, ?)';
			$params = [
				$user->getPseudo(),
				$user->getPassword(),
				$user->getPrivilege()
			];

			$result = (Object) $this->execQuery( $query, $params );

			if ( !$result->success )
				throw new InputValidatorExceptions(
					"Impossible d'ajouter l'utilisateur",
					$result->message,
					TYPE_FEEDBACK_DANGER
				);
		}

		/**
		 * Recherche un utilisateur (Par sa clé primaire: Nom)
		 *
		 * @param $pseudo
		 *
		 * @return null|User
		 */
		public function findUser( $pseudo ) {
			$query  = 'SELECT * FROM user WHERE pseudo = ?';
			$params = [
				$pseudo
			];

			$user = $this->findOne( $query, $params );

			//var_dump( $user );

			if ( !is_null( $user ) )
				$user = new User( $user->pseudo, $user->password, $user->privilege );

			return $user;
		}
	}