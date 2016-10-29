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
		 * Génération des données du contenu
		 */
		protected function makeContent() {
			// TODO: Implement makeContent() method.
		}
	}