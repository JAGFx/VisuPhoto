<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 19/10/2016
	 * Time: 20:55
	 */
	abstract class Controller {
		/**
		 * @var DAO
		 */
		private $_dao = null;

		/**
		 * @var array
		 */
		protected $_menu;

		/**
		 * Variable de données pour le corps de la page
		 *
		 * @var array
		 */
		protected $_dataContent;

		/**
		 * Controller constructor.
		 *
		 * @param string $nameDAO
		 */
		protected function __construct( $nameDAO = null ) {
			$this->_dao         = $this->setDAO( $nameDAO );
			$this->_dataContent = [ ];
		}

		/**
		 * Méthode factorisé à tous les Contrôleur. Et indique les menu minimaux
		 */
		protected function makeMenu() {
			$this->_menu[ 'Home' ]     = "./";
			$this->_menu[ 'A propos' ] = BASE_URL . "viewAPropos";
		}

		/**
		 *
		 */
		protected abstract function makeContent();

		/**
		 * Convertis les données de class en un tableau
		 *
		 * @return array
		 */
		protected abstract function toData();

		/**
		 * Effectue la préparation des données et importe les vues
		 *
		 * @param string $fx Nom de la fonction appelante
		 */
		protected final function renderView( $fx ) {
			// Génération des données de class
			$this->makeMenu();
			$this->makeContent();

			$className = str_replace( 'Controller', '', get_class( $this ) );

			/**
			 * Exemple pris: photoMatrixAction
			 *
			 * Les noms des méthodes action sont normalisées
			 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
			 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
			 */
			$functionName = str_replace( 'Action', '', $fx );
			$path         = __DIR__ . '/../view/' . $className . '/' . $functionName . '.view.php';

			// Génération des données pour la vue
			$data = (Object) array_merge(
				$this->toData(),
				$this->_dataContent,
				[ 'view' => $path ]
			);

			// Importation de la vue par défaut et de la sous-vue associé
			require __DIR__ . '/../view/Default/default.view.php';
		}

		/**
		 * @param $name
		 *
		 * @return DAO
		 * @throws Exception
		 */
		protected final function loadDAO( $name ) {
			$path = __DIR__ . '/DAO/' . $name . '.dao.php';

			if ( !is_file( $path ) )
				throw new Exception( ERR_INVALID_DAO_NAME . ' : ' . $path );

			require $path;

			return new $name();
		}

		/**
		 * @return DAO|null
		 */
		protected function getDAO() {
			return $this->_dao;
		}

		private function setDAO( $nameDAO ) {
			return ( !is_null( $nameDAO ) )
				? $this->loadDAO( $nameDAO )
				: null;
		}
	}