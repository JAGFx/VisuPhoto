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

		public function editUser( User $user ) {
			$query  = 'UPDATE user SET password = ?, avatar = ? WHERE pseudo = ?';
			$params = [
				$user->getPassword(),
				str_replace( User::BASE_PATH, '', $user->getAvatar() ),
				$user->getPseudo()
			];

			$res = (Object) $this->execQuery( $query, $params );

			if ( !$res->success )
				throw new InputValidatorExceptions(
					"Impossible de modifier l'utilisateur",
					$res->message,
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

			$userFind = $this->findOne( $query, $params );

			if ( !is_null( $userFind ) ) {
				$user = new User( $userFind->pseudo, $userFind->password, $userFind->privilege );
				$user->setAvatar( $userFind->avatar );

			} else
				$user = null;

			return $user;
		}

		public function findVoteUser( User $user ) {
			$query  = 'SELECT i.*, n.valueJug FROM image i NATURAL JOIN note n WHERE n.pseudo = ? ORDER BY i.id';
			$params = [
				$user->getPseudo()
			];

			return $this->findAll( $query, $params );
		}
	}