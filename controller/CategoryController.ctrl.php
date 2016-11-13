<?php
	use InputValidator\InputValidatorExceptions;

	/**
	 * Created by PhpStorm.
	 * User: kevin
	 * Date: 13/11/2016
	 * Time: 10:30
	 */
	class CategoryController extends Controller {

		/**
		 * @var string Nom de la catégorie
		 */
		private $_name;


		/**
		 * CategoryController constructor.
		 */
		public function __construct() {
			parent::__construct( 'ImageDAO' );

			$this->setName( $_GET[ "catName" ] );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Affiche la liste des catégorie - Tableau de bord seulement
		 *
		 * @throws \Exception
		 */
		public function viewListCategoryAction() {

			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				$this->makeMenu();
				$this->makeContent();

				$listCategory = $this->getDAO()->getListCategory();

				$this->getViewManager()
				     ->setPageView( 'Dashboard/base' )
				     ->setValue( 'listCategory', $listCategory )
				     ->render( 'Photo/listCategory' );

			} else
				$this->redirectToRoute( 'loginUser' );

		}

		/**
		 * Action pour suppression d'une catégorie
		 */
		public function deleteCategoryAction() {

			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				try {
					$this->getDAO()->deletecategoryImage( $this->getName() );
					$this->redirectToRoute( 'viewlistCategory' );

				} catch ( InputValidatorExceptions $ive ) {
					// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
					echo ivExceptionToAjax( (object) $ive->getError() );
				}

			} else
				$this->redirectToRoute( 'loginUser' );

		}


		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		public function makeContent() { }


		/**
		 * Génération des données du menu
		 * Méthode factorisé à tous les Contrôleur. Indique les menu minimaux
		 */
		protected function makeMenu() {
			parent::makeMenu();

			$this->getViewManager()->setValue(
				'menuAdmin',
				[
					'Connexion'   => BASE_URL . "loginUser",
					'Inscription' => BASE_URL . "registerUser"
				]
			);
		}


		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * @return ImageDAO|null
		 */
		protected function getDAO() {
			return parent::getDAO();
		}

		/**
		 * @return string
		 */
		public function getName() {
			return $this->_name;
		}

		/**
		 * @param string $name
		 */
		public function setName( &$name ) {
			$this->_name = ( isset( $name ) && !empty( $name ) )
				? htmlentities( $name )
				: null;
		}


	}