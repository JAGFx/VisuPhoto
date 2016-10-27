<?php

	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 19/10/2016
	 * Time: 20:27
	 */

	/**
	 * Exemple pris: photoMatrixAction
	 *
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 */

	/**
	 * Class HomeController
	 *
	 * Contrôleur pour la page d'accueil
	 */
	class HomeController extends Controller {


		/**
		 * HomeController constructor.
		 */
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Rendue de page par défaut
		 */
		public function homeAction() {
			// Génération de la vue
			$this->renderView( __FUNCTION__ );
		}

		/**
		 * Génération des données du menu
		 */
		protected function makeMenu() {
			parent::makeMenu();
			$this->_menu[ 'Voir photos' ] = BASE_URL . 'viewPhoto';
		}

		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() { }

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
	}
