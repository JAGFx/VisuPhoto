<?php

	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 19/10/2016
	 * Time: 20:55
	 */

	require __DIR__ . '/../ViewManager/ViewManager.class.php';

	/**
	 * Class Controller
	 *
	 * Contrôleur de base
	 */
	abstract class Controller {
		/**
		 * @var DAO DAO associé au contrôleur (Entité)
		 */
		private $_dao = null;

		/**
		 * @var ViewManager Gestionnaire de vue pour le contrôleur
		 */
		private $_viewManager;

		/**
		 * @var null|string Nom du DAO
		 */
		protected $_nameDAO;

		/**
		 * Controller constructor.
		 *
		 * @param string $nameDAO Nom du DAO à charger
		 */
		protected function __construct( $nameDAO = null ) {
			$this->_nameDAO = $nameDAO;
			$this->_dao     = $this->setDAO( $this->_nameDAO );

			$this->_viewManager = new ViewManager();
			$this->_viewManager->setPageView( 'Default/default' );
		}

		/**
		 * Génération des données du menu
		 * Méthode factorisé à tous les Contrôleur. Indique les menu minimaux
		 */
		protected function makeMenu() {
			$this->_viewManager->setValue(
				'menu',
				[
					'Home'     => "./",
					'A propos' => BASE_URL . "viewAPropos",
					'Photos'   => BASE_URL . "viewPhoto"
				]
			);
		}

		/**
		 * Génération des données du contenu
		 */
		protected abstract function makeContent();

		/**
		 * Redirige vers une route
		 *
		 * @param string|null $route
		 */
		protected final function redirectToRoute( $route = null ) {
			$path = ( is_null( $route ) )
				? './'
				: BASE_URL . $route;
			header( 'Location: ' . $path );
		}

		/**
		 * @return \DAO|null
		 * @throws \Exception
		 */
		protected function getDAO() {

			if ( !$this->_dao instanceof $this->_nameDAO )
				throw new Exception(
					ERR_INVALID_DAO_INSTANCE . ' : Instance [ ' . $this->_nameDAO . ' ] - DAO [ ' . get_class(
						$this->_dao
					) . ' ]'
				);

			return $this->_dao;
		}

		/**
		 * @param string $nameDAO
		 *
		 * @return DAO|null
		 * @throws Exception
		 */
		private function setDAO( $nameDAO ) {
			return ( !is_null( $nameDAO ) )
				? loadDAO( $nameDAO )
				: null;
		}

		/**
		 * @return ViewManager
		 */
		protected function getViewManager() {
			return $this->_viewManager;
		}
	}
