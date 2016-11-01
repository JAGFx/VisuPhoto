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
				$photoDAO = loadDAO( 'ImageDAO' );
				$albumDAO = loadDAO( 'AlbumDAO' );

				$this->_dataContent[ 'listeCtge' ]   = $photoDAO->getListCategory();
				$this->_dataContent[ 'listImg' ]     = $photoDAO->getFullImageList();
				$this->_dataContent[ 'listImgUser' ] = $albumDAO->findListAlbumByUser(
					UserSessionManager::getSession()
				);
				$this->renderView( __FUNCTION__ );

			} else
				$this->redirectToRoute( 'loginUser' );
		}

		public function editionDashboardAction() {
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				$entity = ( isset( $_GET[ 'e' ] ) && !empty( $_GET[ 'e' ] ) )
					? htmlentities( $_GET[ 'e' ] )
					: null;
				$id     = ( isset( $_GET[ 'i' ] ) && !empty( $_GET[ 'i' ] ) )
					? htmlentities( $_GET[ 'i' ] )
					: null;

				$albumDAO = loadDAO( 'AlbumDAO' );
				$photoDAO = loadDAO( 'ImageDAO' );
				if ( $entity === 'Album' ) {

					$this->_dataContent[ 'albumToEdit' ] = $albumDAO->findAlbumById( $id );
					$this->_dataContent[ 'listImg' ]     = $photoDAO->getFullImageList();
					$this->_dataContent[ 'pathInclude' ] = __DIR__ . '/../view/Album/editAlbum.view.php';
				}

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
					'Liste' => '#listAlbum',
					'Créer' => '#addAlbum'
				],
				'Image' => [
					'Liste' => '#listImage',
					'Créer' => '#addImage'
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