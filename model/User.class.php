<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 25/10/2016
	 * Time: 19:39
	 */
	final class User {
		/**
		 * @var string
		 */
		private $_pseudo;

		/**
		 * @var string
		 */
		private $_password;

		/**
		 * @var int
		 */
		private $_privilege;

		/**
		 * User constructor.
		 *
		 * @param string $pseudo
		 * @param string $password
		 * @param int    $privilege
		 */
		public function __construct(
			$pseudo,
			$password = null,
			$privilege = UserSessionManager::USER_PRIVILEGE
		) {
			$this->_pseudo    = $pseudo;
			$this->_password  = $password;
			$this->_privilege = (int) $privilege;
		}

		/**
		 * @return string
		 */
		public function getPseudo() {
			return $this->_pseudo;
		}

		/**
		 * @return string
		 */
		public function getPassword() {
			return $this->_password;
		}

		/**
		 * @return int
		 */
		public function getPrivilege() {
			return $this->_privilege;
		}

		/**
		 * serialize() checks if your class has a function with the magic name __sleep.
		 * If so, that function is executed prior to any serialization.
		 * It can clean up the object and is supposed to return an array with the names of all variables of that object that should be serialized.
		 * If the method doesn't return anything then NULL is serialized and E_NOTICE is issued.
		 * The intended use of __sleep is to commit pending data or perform similar cleanup tasks.
		 * Also, the function is useful if you have very large objects which do not need to be saved completely.
		 *
		 * @return array|NULL
		 * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.sleep
		 */
		public function __sleep() {
			return [ '_pseudo', '_privilege' ];
		}


	}