<?php

	/**
	 * Exemple pris: photoMatrixAction
	 *
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 */

	/**
	 * Class AProposController
	 *
	 * Contrôleur pour la page 'A propos'
	 */
	class AProposController extends Controller {


		/**
		 * AProposController constructor.
		 *
		 */
		public function __construct() {
			parent::__construct();
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue de page par défaut
		 */
		public function aProposAction() {
			// Génération de la vue
			$this->renderView( __FUNCTION__ );
		}

		// ---------------------------------------------------------------------------------------------- Maker
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
