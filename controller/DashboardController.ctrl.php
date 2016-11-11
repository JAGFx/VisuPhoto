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
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendu de la page par défaut du dashboard
		 *
		 * @throws Exception
		 */
		public function dashboardAction() {
			// Accessible que si utilisateur connecté
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				$this->makeMenu();

				$this->getViewManager()
				     ->setPageView( 'Dashboard/base' )
				     ->render( 'Dashboard/dashboard' );

			} else
				$this->redirectToRoute( 'loginUser' );
		}

		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() { }
	}