<?php

	class PhotoMatrixController extends Controller {
		private $_img;
		private $_size;
		private $_nbImg;

		private $_navBarContent;

		private $_matrix;

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
			$this->setNbImg( $_GET[ "nbImg" ] );
		}

		public function photoMatrixAction() {
			# Calcul la liste des images à afficher
			$imgLst = $this->_dao->getImageList( $this->getImg(), $this->_nbImg );

			# Transforme cette liste en liste de couples (tableau a deux valeurs)
			# contenant l'URL de l'image et l'URL de l'action sur cette image
			foreach ( $imgLst as $i ) {
				# l'identifiant de cette image $i
				$iId = $i->getId();
				# Ajoute à imgMatrixURL
				#  0 : l'URL de l'image
				#  1 : l'URL de l'action lorsqu'on clique sur l'image : la visualiser seul
				$this->_matrix[] = [ $i->getPath(), BASE_URL . "viewPhoto&imgId=$iId" ];
			}

			/*$this->makeMenu();
			$this->makeContent();


			$data = $this->toData();
			require __DIR__ . '/../view/PhotoMatrix/photoMatrix.view.php';*/
			$this->showView( __FUNCTION__ );
		}

		public function firstPhotoMatrixAction() {
			$firstImg = $this->_dao->getFirstImage();
			$this->setImg( $firstImg );

			$this->photoMatrixAction();
		}

		public function morePhotoMatrixAction() {
			$moreNbImg = $this->getNbImg() * 2;
			$this->setNbImg( $moreNbImg );

			$this->photoMatrixAction();
		}

		public function lessPhotoMatrixAction() {
			$lessNbImg = ( $this->getNbImg() / 2 < 1 ) ? 1 : $this->getNbImg() / 2;
			$this->setNbImg( $lessNbImg );

			$this->photoMatrixAction();
		}

		public function randomPhotoMatrixAction() {
			// TODO Random matrix
		}

		public function prevPhotoMatrixAction() {
			$prevImg = $this->_dao->jumpToImage( $this->getImg(), ( -$this->getNbImg() ) );
			$this->setImg( $prevImg );

			$this->photoMatrixAction();
		}

		public function nextPhotoMatrixAction() {
			$nextImg = $this->_dao->jumpToImage( $this->getImg(), $this->getNbImg() );
			$this->setImg( $nextImg );

			$this->photoMatrixAction();
		}

		protected function makeMenu() {
			parent::makeMenu();

			# Change l'etat pour indiquer que cette image est la nouvelle
			$this->_menu[ 'First' ] = BASE_URL . "firstPhotoMatrix&imgId=" .
						  $this->getImg()->getId() . "&nbImg=" . $this->getNbImg(
				) . "&size=" . $this->getSize();

			// TODO Random matrix
			$this->_menu[ 'Random' ] = "nonRealise.php";

			$this->_menu[ 'More' ] = BASE_URL . "morePhotoMatrix&imgId=" .
						 $this->getImg()->getId() . "&nbImg=" . $this->getNbImg();


			$this->_menu[ 'Less' ] = BASE_URL . "lessPhotoMatrix&imgId=" .
						 $this->getImg()->getId() . "&nbImg=" . $this->getNbImg();
		}

		protected function makeContent() {
			$this->_navBarContent = [
				"Prev" => BASE_URL . 'prevPhotoMatrix&imgId=' .
					  ( $this->getImg()->getId() - $this->getNbImg() ) . '&nbImg=' .
					  $this->getNbImg() . '&size=' . $this->getSize(),

				"Next" => BASE_URL . 'nextPhotoMatrix&imgId=' .
					  ( $this->getImg()->getId() + $this->getNbImg() ) . '&nbImg=' .
					  $this->getNbImg() . '&size=' . $this->getSize()
			];

			/*$nextImg = $this->_dao->getNextImage( $data[ 'img' ] );
			$data[ 'nextImgLink' ] = BASE_URL . 'jumpTo&imgId=' .
				$nextImg->getId() . '&nbJump=' . $this->getNbImg() . '&nbImg=' .
				$this->getNbImg() . '&size=' . $this->getSize();*/

			$size = MIN_WIDTH_PIC / sqrt( count( $this->_matrix ) );
			$this->setSize( $size );

		}

		protected function toData() {
			return (Object) [
				'img'           => $this->_img,
				'imgMatrixURL'  => $this->_matrix,
				'menu'          => $this->_menu,
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
		 * @param mixed $img
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
		 * @param $size
		 */
		private function setSize( &$size ) {
			$this->_size = (int) ( isset( $size ) )
				? htmlentities( $size )
				: MIN_WIDTH_PIC;
		}

		/**
		 * @return mixed
		 */
		public function getNbImg() {
			return (int) $this->_nbImg;
		}

		/**
		 * @param mixed $nbImg
		 */
		private function setNbImg( &$nbImg ) {
			$this->_nbImg = ( isset( $nbImg ) ) ? (int) htmlentities( $nbImg ) : MIN_NB_PIC;
		}


	}
