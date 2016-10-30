<?php

	/**
	 * Exemple pris: photoMatrixAction
	 *
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 */

	/**
	 * Class PhotoController
	 *
	 * Contrôleur pour l'affichage d'une photo
	 */
	class PhotoController extends Controller {
		/**
		 * @var Image Image actuel
		 */
		private $_img;

		/**
		 * @var int Taille en hauteur maximal actuel
		 */
		private $_size;

		/**
		 * PhotoController constructor.
		 */
		public function __construct() {
			parent::__construct( 'ImageDAO' );

			// Récupération de l'image actuel si défini
			$img = ( isset( $_GET[ "imgId" ] ) )
				? $this->getDAO()->getImage( htmlentities( $_GET[ "imgId" ] ) )
				: null;

			$this->setImg( $img );
			$this->setSize( $_GET[ "size" ] );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue de page par défaut
		 */
		public function photoAction() {
			// Création des variables de contenu
			$this->_dataContent[ 'url' ] = BASE_URL . "zoommorePhoto&imgId=" . $this->getImg()->getId(
				) . "&size=" . $this->getSize();

			// Génération de la vue
			$this->renderView( __FUNCTION__ );
		}

		/**
		 * Traitement pour accèder à la première image
		 */
		public function firstPhotoAction() {
			// Traitement
			$firstImg = $this->getDAO()->getFirstImage();
			$this->setImg( $firstImg );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour accèder à une image aléatoirement
		 */
		public function randomPhotoAction() {
			// Traitement
			$randomImg = $this->getDAO()->getRandomImage();
			$this->setImg( $randomImg );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour zoomer l'image actuel
		 */
		public function zoommorePhotoAction() {
			// Traitement
			$ratio = $this->getSize() * MORE_RATIO;
			$this->setSize( $ratio );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour de-zoomer l'image actuel
		 */
		public function zoomlessPhotoAction() {
			// Traitement
			$ratio = $this->getSize() * LESS_RATIO;
			$this->setSize( $ratio );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour accèder à l'image précedente
		 */
		public function prevPhotoAction() {
			// Traitement
			$prevImg = $this->getDAO()->getPrevImage( $this->getImg() );
			$this->setImg( $prevImg );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour accèder à l'image suivante
		 */
		public function nextPhotoAction() {
			// Traitement
			$prevImg = $this->getDAO()->getNextImage( $this->getImg() );
			$this->setImg( $prevImg );

			// Génération de la vue
			$this->photoAction();
		}


		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du menu
		 */
		protected function makeMenu() {
			parent::makeMenu();
			$this->_menu[ 'Connexion' ]   = BASE_URL . "loginUser";
			$this->_menu[ 'Inscription' ] = BASE_URL . "registerUser";
		}

		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() {
			$this->_dataContent[ 'navBar' ] = [
				"Previous" => BASE_URL . 'prevPhoto&imgId=' .
					      ( $this->getImg()->getId() ) . '&size=' . $this->getSize(),

				"Next"  => BASE_URL . 'nextPhoto&imgId=' .
					   ( $this->getImg()->getId() ) . '&size=' . $this->getSize(),
				"First" => BASE_URL . "firstPhoto&imgId=" .
					   $this->getImg()->getId() . "&size=" . $this->getSize(),

				"Random" => BASE_URL . "randomPhoto&imgId=" .
					    $this->getImg()->getId() . "&size=" . $this->getSize(),

				"More" => BASE_URL . "morePhotoMatrix&imgId=" .
					  $this->getImg()->getId() . "&size=" . $this->getSize(),

				"Zoom +" => BASE_URL . "zoommorePhoto&imgId=" .
					    $this->getImg()->getId() . "&size=" . $this->getSize(),

				"Zoom -" => BASE_URL . "zoomlessPhoto&imgId=" .
					    $this->getImg()->getId() . "&size=" . $this->getSize(),

				"list" => $this->getDAO()->getListCategory()
			];

			$this->_dataContent[ 'listCategoty' ] = BASE_URL . "filtrebycategoryPhotoMatrix&imgId=" .
								$this->getImg()->getId() . "&nbImg=" . MIN_NB_PIC
								. "&flt=";
		}

		/**
		 * Convertis les données de class en un tableau
		 *
		 * @return array
		 */
		protected function toData() {
			return [
				'img'  => $this->_img,
				'menu' => $this->_menu,
				'size' => $this->_size
			];
		}


		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * @return Image
		 */
		public function getImg() {
			return $this->_img;
		}

		/**
		 * @param &Image $img
		 */
		private function setImg( &$img ) {
			$this->_img = ( isset( $img ) && !empty( $img ) )
				? $img
				: $this->getDAO()->getFirstImage();
		}

		/**
		 * @return int
		 */
		public function getSize() {
			return $this->_size;
		}

		/**
		 * @param &int $size
		 */
		private function setSize( &$size ) {
			$this->_size = (int) ( isset( $size ) )
				? htmlentities( $size )
				: MIN_WIDTH_PIC;
		}

		/**
		 * Non nécessaire. Utilisé pour caster l'objet DAO en ImageDAO pour l'IDE
		 *
		 * @return ImageDAO
		 */
		protected function getDAO() {
			return parent::getDAO();
		}


	}
