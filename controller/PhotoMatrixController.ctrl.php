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

		private $_popularite;
		

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
			$this->setPopularite( $_GET[ "popularite" ] );
		}


		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue de page par défaut
		 */
		public function photoMatrixAction() {
			$this->makeMenu();
			$this->makeContent();

			$matrix = [ ];

			// Calcul la liste des images à afficher
			$imgLst = $this->getDAO()->getImageList( $this->getImg(), $this->_nbImg );


			// Transforme cette liste en liste de couples (tableau a deux valeurs)
			// contenant l'URL de l'image et l'URL de l'action sur cette image
			foreach ( $imgLst as $i ) {
				// l'identifiant de cette image $i
				$iId = $i->getId();

				/*  Ajoute à imgMatrixURL
				  0 : l'URL de l'image
				  1 : l'URL de l'action lorsqu'on clique sur l'image : la visualiser seul
				*/
				$matrix[] = [
					$i,
					BASE_URL . "viewPhoto&imgId=$iId" . '&nbImg=' .
					$this->getNbImg() . '&size=' . $this->getSize()
				];
			}

			// Génération de la vue
			$this->getViewManager()->setValue( 'matrix', $matrix );

			$this->getViewManager()->render( 'PhotoMatrix/photoMatrix' );
		}

		/**
		 * Filtrage des images de la matrice par catégorie
		 */
		public function filtreByCategoryAction() {
			$this->makeMenu();
			$this->makeContent();

			$matrix = [ ];

			$filtreImages = $this->getDAO()->filtreImage(
				$this->getImg(), $this->getFiltre(), $this->getNbImg()
			);

			//var_dump($filtreImages);

			foreach ( $filtreImages as $image )
				$matrix[] = [
					$image,
					BASE_URL . "viewPhoto&imgId=" . $image->getId()
				];

			$this->getViewManager()->setValue( 'matrix', $matrix );

			$this->getViewManager()->render( 'PhotoMatrix/filtreByCategory' );
		}


		public function populariteAction() {
			$this->makeMenu();
			$this->makeContent();

			$matrix = [ ];

			$filtreImages = $this->getDAO()->populariteImage( $this->getImg(), $this->getNbImg() );

			foreach ( $filtreImages as $image )
				$matrix[] = [
					$image,
					BASE_URL . "viewPhoto&imgId=" . $image->getId()
				];

			$this->getViewManager()->setValue( 'matrix', $matrix );

			$this->getViewManager()->render( 'PhotoMatrix/popularite' );
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

        public function lastPhotoMatrixAction()
        {
            // Traitement
            $lastImg = $this->getDAO()->getLastImage();

            $this->setImg($lastImg);

            // Génération de la vue
            (is_null($this->getFiltre()))
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
			if ( !is_null( $this->getFiltre() ) ) {
				$this->filtreByCategoryAction();
			} elseif ( $this->getPopularite() == "true" ) {
				$this->populariteAction();
			} else {
				$this->photoMatrixAction();
			}


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
			if ( !is_null( $this->getFiltre() ) ) {
				$this->filtreByCategoryAction();
			} elseif ( ( $this->getPopularite() == "true" ) ) {
				$this->populariteAction();
			} else {
				$this->photoMatrixAction();
			}


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
		protected function makeContent() {
			$this->getViewManager()->setValue(
				'navBar',
				[
					"Previous" => BASE_URL . 'prevPhotoMatrix&imgId=' .
						      $this->getImg()->getId() . '&nbImg=' .
						      $this->getNbImg() . '&size=' . $this->getSize()
						      . "&flt=" . $this->getFiltre(
						) . "&popularite=" . $this->getPopularite(),
					"Next"     => BASE_URL . 'nextPhotoMatrix&imgId=' .
						      $this->getImg()->getId() . '&nbImg=' .
						      $this->getNbImg() . '&size=' . $this->getSize()
						      . "&flt=" . $this->getFiltre(
						) . "&popularite=" . $this->getPopularite(),

					"First" => BASE_URL . "firstPhotoMatrix&imgId=" .
						   $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
						) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(
						) . "&popularite=" . $this->getPopularite(),

					"Random" => BASE_URL . "randomPhotoMatrix&imgId=" .
						    $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
						) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(),

					"More" => BASE_URL . "morePhotoMatrix&imgId=" .
						  $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
						) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(
						) . "&popularite=" . $this->getPopularite(),

					"Less" => BASE_URL . "lessPhotoMatrix&imgId=" .
						  $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
						) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(
						) . "&popularite=" . $this->getPopularite(),

					"list" => $this->getDAO()->getListCategory(),

					"Popularite" => BASE_URL . "popularitePhotoMatrix&imgId=" .
							$this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
						) . "&size=" . $this->getSize() . "&popularite=" . $this->getPopularite(
						),

					"Last" => BASE_URL . "lastPhotoMatrix&imgId=" .
						  $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
						) . "&size=" . $this->getSize() . "&flt=" . $this->getFiltre(
						) . "&popularite=" . $this->getPopularite(),
				]
			);

			$this->getViewManager()->setValue(
				'currentCategory', $this->getFiltre()
			);

			$this->getViewManager()->setValue(
				'listCategoty', BASE_URL . "filtrebycategoryPhotoMatrix&imgId=" .
						$this->getImg()->getId() . "&nbImg=" .
						$this->getNbImg() . "&flt="
			);

			$this->getViewManager()->setValue( 'img', $this->_img );
			$this->getViewManager()->setValue( 'size', $this->_size );
		}


		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * @return Image
		 */
		public function getImg() {
			return $this->_img;
		}

		/**
		 * @param Image $img
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
		 * @param int $size
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
		 * @param string $filtre
		 */
		public function setFiltre( &$filtre ) {
			$this->_filtre = ( isset( $filtre ) && !empty( $filtre ) )
				? htmlentities( $filtre )
				: null;
		}


		/**
		 * @return string
		 */
		public function getPopularite() {
			return $this->_popularite;
		}

		/**
		 * @param string $popularite
		 */
		public function setPopularite( &$popularite ) {
            $this->_popularite = (isset($popularite) && (!empty($popularite) && $popularite == "true"))
                ? "true"
                : "false";
		}


		/**
		 * @return int
		 */
		public function getNbImg() {
			return (int) $this->_nbImg;
		}

		/**
		 * @param int $nbImg
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
