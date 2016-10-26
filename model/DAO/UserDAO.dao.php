<?php

	require __DIR__ . '/../User.class.php';

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 25/10/2016
	 *        Time: 19:54
	 */
	class UserDAO extends DAO {

		public function addUser( User $user ) {
			$query  = 'INSERT INTO user VALUES(?, ?, ?)';
			$params = [
				$user->getPseudo(),
				$user->getPassword(),
				$user->getPrivilege()
			];

			return $this->execQuery( $query, $params );
		}

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