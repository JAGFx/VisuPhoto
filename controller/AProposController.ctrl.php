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
			$this->makeMenu();
			$this->makeContent();

			// Génération de la vue
			$this->getViewManager()->render( 'APropos/aPropos' );
		}

		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du menu
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

		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() { }
	}
