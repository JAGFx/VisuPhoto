<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 25/10/2016
	 * Time: 19:39
	 */
	final class User {
		const USER_PRIVILEGE  = 0;
		const ADMIN_PRIVILEGE = 1;

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
		public function __construct( $pseudo, $password = null, $privilege = self::USER_PRIVILEGE ) {
			$this->_pseudo    = $pseudo;
			$this->_password  = $password;
			$this->_privilege = $privilege;
		}

		/**
		 * @return bool
		 */
		public function hasAdminPrivilege() {
			return $this->_privilege == self::ADMIN_PRIVILEGE;
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


	}