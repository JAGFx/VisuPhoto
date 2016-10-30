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
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) )
				$this->renderView( __FUNCTION__ );

			else
				$this->redirectToRoute( 'loginUser' );
		}

		/**
		 * Convertis les données de class en un tableau
		 *
		 * @return array
		 */
		protected function toData() {
			return [
				'menu'       => $this->_menu,
				'pathLogout' => BASE_URL . 'logoutUser',
				'subNav'     => $this->_subNav
			];
		}



		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() {
			$this->_subNav = [
				'Album' => [
					'Créer'     => 'path',
					'Modifier'  => 'path',
					'Supprimer' => 'path'
				],
				'Image' => [
					'Créer'     => 'path',
					'Modifier'  => 'path',
					'Supprimer' => 'path'
				]
			];
		}
	}