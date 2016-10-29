<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 19/10/2016
	 * Time: 20:55
	 */

	/**
	 * Class Controller
	 *
	 * Contrôleur de base
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
		 * Vue principale
		 *
		 * @var string
		 */
		private $_defaultView = __DIR__ . '/../view/Default/default.view.php';

		/**
		 * Controller constructor.
		 *
		 * @param string $nameDAO Nom du DAO à charger
		 */
		protected function __construct( $nameDAO = null ) {
			$this->_dao         = $this->setDAO( $nameDAO );
			$this->_dataContent = [ ];
		}

		/**
		 * Génération des données du menu
		 * Méthode factorisé à tous les Contrôleur. Indique les menu minimaux
		 */
		protected function makeMenu() {
			$this->_menu[ 'Home' ]        = "./";
			$this->_menu[ 'A propos' ]    = BASE_URL . "viewAPropos";
			$this->_menu[ 'Connexion' ]   = BASE_URL . "loginUser";
			$this->_menu[ 'Inscription' ] = BASE_URL . "registerUser";
		}

		/**
		 * Génération des données du contenu
		 */
		protected abstract function makeContent();

		/**
		 * Convertis les données de class en un tableau
		 *
		 * @return array
		 */
		protected function toData() {
			return [
				'menu' => $this->_menu
			];
		}

		/**
		 * Effectue la préparation des données et importe les vues
		 *
		 * @param string $fx Nom de la fonction appelante
		 *
		 * @throws Exception
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

			if ( !is_file( $path ) )
				throw new Exception( ERR_INVALID_VIEW_NAME . ' : ' . $className . '/' . $functionName );

			// Génération des données pour la vue
			$data = (Object) array_merge(
				$this->toData(),
				$this->_dataContent,
				[ 'view' => $path ]
			);

			// Importation de la vue par défaut et de la sous-vue associé
			require $this->_defaultView;
		}

		/**
		 * Charge un DAO spécifique
		 *
		 * @param string $name
		 *
		 * @return DAO
		 * @throws Exception
		 */
		private function loadDAO( $name ) {
			$path = __DIR__ . '/DAO/' . $name . '.dao.php';

			if ( !is_file( $path ) )
				throw new Exception( ERR_INVALID_DAO_NAME . ' : ' . $name );

			require $path;

			return new $name();
		}

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
		 * @return DAO|null
		 */
		protected function getDAO() {
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
				? $this->loadDAO( $nameDAO )
				: null;
		}

		/**
		 * @param $defaultView
		 *
		 * @throws Exception
		 */
		protected final function setDefaultView( $defaultView ) {
			$path = __DIR__ . '/../view/' . $defaultView;

			if ( !is_file( $path ) )
				throw new Exception( ERR_INVALID_VIEW_NAME . ' : ' . $defaultView );

			$this->_defaultView = $path;
		}

	}
