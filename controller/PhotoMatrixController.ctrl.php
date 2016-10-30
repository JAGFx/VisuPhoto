<?php

	/**
	 * Exemple pris: photoMatrixAction
	 *
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 */

	/**
	 * Class PhotoMatrixController
	 *
	 * Contrôleur pour l'affichage d'une matrice d'image
	 */
	class PhotoMatrixController extends Controller {
		/**
		 * @var Image Image actuel
		 */
		private $_img;
		/**
		 * @var int Taille en hauteur maximal actuel
		 */
		private $_size;
		/**
		 * @var int Nombre affiché dans la matrice
		 */
		private $_nbImg;
		/**
		 * @var string Nom du paramètre de filtrage (Catégorie)
		 */
		private $_filtre;
		

		/**
		 * PhotoController constructor.
		 */
		public function __construct() {
			parent::__construct( 'ImageDAO' );

			$img = ( isset( $_GET[ "imgId" ] ) )
				? $this->getDAO()->getImage( htmlentities( $_GET[ "imgId" ] ) )
				: null;

			$this->setImg( $img );
			$this->setSize( $_GET[ "size" ] );
			$this->setNbImg( $_GET[ "nbImg" ] );
			$this->setFiltre( $_GET[ "flt" ] );
		}


		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue de page par défaut
		 */
		public function photoMatrixAction() {
			# Calcul la liste des images à afficher
			$imgLst = $this->getDAO()->getImageList( $this->getImg(), $this->_nbImg );

			# Transforme cette liste en liste de couples (tableau a deux valeurs)
			# contenant l'URL de l'image et l'URL de l'action sur cette image
			foreach ( $imgLst as $i ) {
				# l'identifiant de cette image $i
				$iId = $i->getId();

				# Ajoute à imgMatrixURL
				#  0 : l'URL de l'image
				#  1 : l'URL de l'action lorsqu'on clique sur l'image : la visualiser seul
				$this->_dataContent[ 'matrix' ][] = [
					$i,
					BASE_URL . "viewPhoto&imgId=$iId" . '&nbImg=' .
					$this->getNbImg() . '&size=' . $this->getSize()
				];
			}

			// Génération de la vue
			$this->renderView( __FUNCTION__ );
		}

		/**
		 * Filtrage des images de la matrice par catégorie
		 */
		public function filtreByCategoryAction() {

			$this->_dataContent[ 'matrix' ] = [ ];

			$filtreImages = $this->getDAO()->filtreImage(
				$this->getImg(), $this->getFiltre(), $this->getNbImg()
			);

			foreach ( $filtreImages as $image )
				$this->_dataContent[ 'matrix' ][] = [
					$image,
					BASE_URL . "viewPhoto&imgId=" . $image->getId()
				];

			$this->renderView( __FUNCTION__ );
		}

		/**
		 * Traitement pour accèder à la première image
		 */
		public function firstPhotoMatrixAction() {
			// Traitement
			$firstImg = $this->getDAO()->getFirstImage();
			$this->setImg( $firstImg );

			// Génération de la vue
			( is_null( $this->getFiltre() ) )
				? $this->photoMatrixAction()
				: $this->filtreByCategoryAction();
		}

		/**
		 * Traitement pour afficher plus d'image dans la matrice
		 */
		public function morePhotoMatrixAction() {
			// Traitement
			$moreNbImg = $this->getNbImg() * 2;
			$this->setNbImg( $moreNbImg );

			// Génération de la vue
			( is_null( $this->getFiltre() ) )
				? $this->photoMatrixAction()
				: $this->filtreByCategoryAction();
		}

		/**
		 * Traitement pour afficher moins d'image dans la matrice
		 */
		public function lessPhotoMatrixAction() {
			// Traitement
			$lessNbImg = ( $this->getNbImg() / 2 < 1 ) ? 1 : $this->getNbImg() / 2;
			$lessNbImg = round( $lessNbImg, 0, PHP_ROUND_HALF_UP );

			$this->setNbImg( $lessNbImg );

			// Génération de la vue
			( is_null( $this->getFiltre() ) )
				? $this->photoMatrixAction()
				: $this->filtreByCategoryAction();
		}

		/**
		 * Traitement pour accèder à une image aléatoirement
		 */
		public function randomPhotoMatrixAction() {
			// Traitement
			$randomImg = $this->getDAO()->getRandomImage( $this->getFiltre() );
			$this->setImg( $randomImg );

			// Génération de la vue
			( is_null( $this->getFiltre() ) )
				? $this->photoMatrixAction()
				: $this->filtreByCategoryAction();
		}

		/**
		 * Traitement pour accèder à l'image précedente
		 */
		public function prevPhotoMatrixAction() {
			// Traitement
			$prevImg = $this->getDAO()->jumpToImage(
				$this->getImg(), ( -$this->getNbImg() ), $this->getFiltre()
			);
			$this->setImg( $prevImg );

			// Génération de la vue
			( is_null( $this->getFiltre() ) )
				? $this->photoMatrixAction()
				: $this->filtreByCategoryAction();
		}

		/**
		 * Traitement pour accèder à l'image suivante
		 */
		public function nextPhotoMatrixAction() {
			// Traitement
			$nextImg = $this->getDAO()->jumpToImage(
				$this->getImg(), $this->getNbImg(), $this->getFiltre()
			);
			$this->setImg( $nextImg );

			// Génération de la vue
			( is_null( $this->getFiltre() ) )
				? $this->photoMatrixAction()
				: $this->filtreByCategoryAction();
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
				"Previous" => BASE_URL . 'prevPhotoMatrix&imgId=' .
					      ( $this->getImg()->getId() - $this->getNbImg() ) . '&nbImg=' .
					      $this->getNbImg() . '&size=' . $this->getSize()
					      . "&flt=" . $this->getFiltre(),

				"Next" => BASE_URL . 'nextPhotoMatrix&imgId=' .
					  ( $this->getImg()->getId() + $this->getNbImg() ) . '&nbImg=' .
					  $this->getNbImg() . '&size=' . $this->getSize()
					  . "&flt=" . $this->getFiltre(),

				"First" => BASE_URL . "firstPhotoMatrix&imgId=" .
					   $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
					) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(),

				"Random" => BASE_URL . "randomPhotoMatrix&imgId=" .
					    $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
					) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(),

				"More" => BASE_URL . "morePhotoMatrix&imgId=" .
					  $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
					) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(),

				"Less" => BASE_URL . "lessPhotoMatrix&imgId=" .
					  $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
					) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(),

				"list" => $this->getDAO()->getListCategory()
			];

			$this->_dataContent[ 'listCategoty' ] = BASE_URL . "filtrebycategoryPhotoMatrix&imgId=" .
								$this->getImg()->getId() . "&nbImg=" .
								$this->getNbImg() . "&flt=";
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
			return (int) $this->_size;
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
		 * @return string
		 */
		public function getFiltre() {
			return $this->_filtre;
		}

		/**
		 * @param &string $filtre
		 */
		public function setFiltre( &$filtre ) {
			$this->_filtre = ( isset( $filtre ) && !empty( $filtre ) )
				? htmlentities( $filtre )
				: null;
		}


		/**
		 * @return int
		 */
		public function getNbImg() {
			return (int) $this->_nbImg;
		}

		/**
		 * @param &int $nbImg
		 */
		private function setNbImg( &$nbImg ) {
			$this->_nbImg = ( isset( $nbImg ) )
				? (int) htmlentities( $nbImg )
				: MIN_NB_PIC;
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
