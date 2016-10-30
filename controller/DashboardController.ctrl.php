<?php
	
	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 29/10/2016
	 *        Time: 13:39
	 */

	/**
	 * Class DashboardController
	 *
	 * Contrôleur pour le dashboard
	 */
	class DashboardController extends Controller {
		private $_subNav;

		/**
		 * DashboardController constructor.
		 */
		public function __construct() {
			parent::__construct();
			$this->setDefaultView( 'Dashboard/base.view.php' );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendu de la page par défaut du dashboard
		 *
		 * @throws Exception
		 */
		public function dashboardAction() {
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				$photoCtrl                         = loadController( 'aPhoto' );
				$this->_dataContent[ 'listeCtge' ] = $photoCtrl->getDAO()->getListCategory();
				$this->renderView( __FUNCTION__ );

			} else
				$this->redirectToRoute( 'loginUser' );
		}

		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() {
			$this->_subNav = [
				'Album' => [
					'Créer'     => '#addAlbum',
					'Modifier'  => 'path',
					'Supprimer' => 'path'
				],
				'Image' => [
					'Créer'     => '#addImage',
					'Modifier'  => 'path',
					'Supprimer' => 'path'
				]
			];
		}

		/**
		 * Convertis les données de class en un tableau
		 *
		 * @return array
		 */
		protected function toData() {
			return [
				'menu'   => $this->_menu,
				'subNav' => $this->_subNav
			];
		}
	}