<?php

	require_once __DIR__ . '/../../model/User.class.php';

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 29/10/2016
	 *        Time: 10:23
	 */

	/**
	 * Class UserSessionManager
	 *
	 * Gère la session pour un utilisateur
	 */
	final class UserSessionManager {
		/**
		 * Constante pour une session sans utilisateur connecté
		 */
		const NO_PRIVILEGE = -1;
		/**
		 * Constante pour le privilège standard
		 */
		const USER_PRIVILEGE = 0;
		/**
		 * Constante pour le privilège admin
		 */
		const ADMIN_PRIVILEGE = 1;

		/**
		 * Initialise la session
		 */
		public static function init() {
			session_start();
		}

		/**
		 * Crée une session utilisateur
		 *
		 * @param User|null $user
		 */
		public static function start( User &$user = null ) {
			session_regenerate_id( true );

			if ( is_null( $user ) )
				$user = ( is_null( self::getSession() ) )
					? new User( 'Invité', null, self::NO_PRIVILEGE )
					: self::getSession();

			$_SESSION[ 'user' ] = serialize( $user );
		}

		/**
		 * Supprime et crée une nouvelle session utilisateur
		 *
		 * @param User|null $user
		 */
		public static function renew( User &$user = null ) {
			self::close();
			self::init();
			self::start( $user );
		}

		/**
		 * Supprime la session utilisateur
		 */
		public static function close() {
			$_SESSION = [ ];
			session_destroy();
		}

		/**
		 * Récupère la session utilisateur
		 *
		 * @return User|null
		 */
		public static function getSession() {
			return ( isset( $_SESSION[ 'user' ] ) && !is_null( $_SESSION[ 'user' ] ) )
				? unserialize( $_SESSION[ 'user' ] )
				: null;
		}

		/**
		 * Défini si un utilisateur à le bon privilège pour l'accès à une ressource
		 *
		 * @param int $priviege
		 *
		 * @return bool
		 */
		public static function hasPrivilege( $priviege ) {
			if ( is_null( self::getSession() ) )
				return false;

			return self::getSession()->getPrivilege() >= $priviege;
		}
	}