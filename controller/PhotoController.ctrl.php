<?php
	# Utilisation du modèle
	// Débute l'acces aux images
	class PhotoController extends Controller {
		private $_img;
		private $_size;

		private $_matrix;

		private $_navBarContent;

		/**
		 * PhotoController constructor.
		 *
		 * @param ImageDAO $_dao
		 */
		public function __construct( ImageDAO $_dao ) {
			parent::__construct( $_dao );

			$img = ( isset( $_GET[ "imgId" ] ) )
				? $_dao->getImage( htmlentities( $_GET[ "imgId" ] ) )
				: null;

			$this->setImg( $img );
			$this->setSize( $_GET[ "size" ] );
		}

		public function photoAction() {
			# Ajoute à imgMatrixURL
			#  0 : l'URL de l'image
			#  1 : l'URL de l'action lorsqu'on clique sur l'image : la visualiser seul
			$this->_matrix = [
				$this->getImg()->getPath(),
				BASE_URL . "zomemorePhoto&imgId=" . $this->getImg()->getId(
				) . "&size=" . $this->getSize()
			];

			$this->showView( __FUNCTION__ );
		}


		protected function makeMenu() {
			parent::makeMenu();

			# Change l'etat pour indiquer que cette image est la nouvelle

			$this->_menu[ 'First' ] = BASE_URL . "firstPhoto&imgId=" .
						  $this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'Random' ] = BASE_URL . "randomPhoto&imgId=" .
						   $this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'More' ] = BASE_URL . "morePhotoMatrix&imgId=" .
						 $this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'Zoom +' ] = BASE_URL . "zomemorePhoto&imgId=" .
						   $this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'Zoom -' ] = BASE_URL . "zomelessPhoto&imgId=" .
						   $this->getImg()->getId() . "&size=" . $this->getSize();
		}

		protected function makeContent() {
			$this->_navBarContent = [
				"Prev" => BASE_URL . 'prevPhoto&imgId=' .
					  ( $this->getImg()->getId() - 1 ) . '&size=' . $this->getSize(),

				"Next" => BASE_URL . 'nextPhoto&imgId=' .
					  ( $this->getImg()->getId() + 1 ) . '&size=' . $this->getSize()
			];
		}

		protected function toData() {
			return (Object) [
				'img'           => $this->_img,
				'menu'          => $this->_menu,
				'matrix'        => $this->_matrix,
				'size'          => $this->_size,
				'navbarContent' => $this->_navBarContent
			];
		}

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
				: $this->_dao->getFirstImage();
		}

		/**
		 * @return mixed
		 */
		public function getSize() {
			return $this->_size;
		}

		/**
		 * @param mixed $size
		 */
		private function setSize( &$size ) {
			$this->_size = (int) ( isset( $size ) )
				? htmlentities( $size )
				: MIN_WIDTH_PIC;
		}

		/**
		 * @return mixed
		 */
		public function getNavBarContent() {
			return $this->_navBarContent;
		}
	}


	/*// Construit l'image courante
	// et l'ID courant
	// NB un id peut être toute chaine de caractère !!
	if ( isset( $_GET[ "imgId" ] ) ) {
		$data[ 'img' ] = $imgDAO->getImage( htmlentities( $_GET[ "imgId" ] ) );
	} else
		$data[ 'img' ] = $imgDAO->getFirstImage();


	$data[ 'size' ] = (int) ( isset( $_GET[ "size" ] ) ) ? htmlentities( $_GET[ "size" ] ) : MIN_WIDTH_PIC;


	$firstImg = $imgDAO->getFirstImage();


	# Mise en place du menu
	$menu[ 'Home' ]     = "./";
	$menu[ 'A propos' ] = BASE_URL . "aPropos";
	// Pre-calcule la première image

	$menu[ 'First' ] = BASE_URL . "viewPhoto&imgId=" . $firstImg->getId() . "&size=" . $data[ 'size' ];
	# Pre-calcule une image au hasard
	$menu[ 'Random' ] = BASE_URL . "randomPhoto&imgId=" . $firstImg->getId() . "&size=" . $data[ 'size' ];
	# Pour afficher plus d'image passe à une autre page
	$menu[ 'More' ] = BASE_URL . "viewPhotoMatrix&imgId=" . $data[ 'img' ]->getId();
	// Demande à calculer un zoom sur l'image
	$menu[ 'Zoom +' ] = BASE_URL . "zoomPhoto&zoom=" . MORE_RATIO . "&imgId=" . $data[ 'img' ]->getId(
		) . "&size=" . $data[ 'size' ];
	// Demande à calculer un zoom sur l'image
	$menu[ 'Zoom -' ] = BASE_URL . "zoomPhoto&zoom=" . LESS_RATIO . "&imgId=" . $data[ 'img' ]->getId(
		) . "&size=" . $data[ 'size' ];
	// Affichage du menu

	$data[ 'menu' ] = $menu;


	$prevImg               = $imgDAO->getPrevImage( $data[ 'img' ] );
	$data[ 'prevImgLink' ] = BASE_URL . 'viewPhoto&imgId=' . $prevImg->getId() . '&size=' . $data[ 'size' ];


	$nextImg               = $imgDAO->getNextImage( $data[ 'img' ] );
	$data[ 'nextImgLink' ] = BASE_URL . 'viewPhoto&imgId=' . $nextImg->getId() . '&size=' . $data[ 'size' ];

	$data[ 'zoomLink' ] = BASE_URL . 'zoomPhoto&zoom=' . MORE_RATIO . '&imgId=' . $data[ 'img' ]->getId(
		) . '&size=' . $data[ 'size' ];

	$data = (Object) $data;
	require __DIR__ . '/../view/Photo/photo.view.php';*/