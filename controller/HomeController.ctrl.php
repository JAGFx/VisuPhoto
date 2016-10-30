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

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue de page par défaut
		 */
		public function homeAction() {
			// Génération de la vue
			$this->renderView( __FUNCTION__ );
		}

		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() { }
	}
