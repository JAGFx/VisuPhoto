<?php
	
	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 29/10/2016
	 *        Time: 13:39
	 */
	class DashboardController extends Controller {

		public function __construct() {
			parent::__construct();
			$this->setDefaultView( 'Dashboard/base.view.php' );
		}

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