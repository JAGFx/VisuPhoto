<?php

	class PhotoController extends Controller {
		/**
		 * @var Image
		 */
		private $_img;

		/**
		 * @var int
		 */
		private $_size;

		/**
		 * @var ImageDAO
		 */
		protected $_dao;

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

		// ---------------------------------------------------------------------------------------------- Actions

		public function photoAction() {
			$this->_dataContent[ 'matrix' ] = [
				$this->getImg()->getPath(),
				BASE_URL . "zoommorePhoto&imgId=" . $this->getImg()->getId(
				) . "&size=" . $this->getSize()
			];

			$this->renderView( __FUNCTION__ );
		}

		public function firstPhotoAction() {
			$firstImg = $this->_dao->getFirstImage();
			$this->setImg( $firstImg );

			$this->photoAction();
		}

		public function randomPhotoAction() {
			$randomImg = $this->_dao->getRandomImage();
			$this->setImg( $randomImg );

			$this->photoAction();
		}

		public function zoommorePhotoAction() {
			$ratio = $this->getSize() * MORE_RATIO;
			$this->setSize( $ratio );

			$this->photoAction();
		}

		public function zoomlessPhotoAction() {
			$ratio = $this->getSize() * LESS_RATIO;
			$this->setSize( $ratio );

			$this->photoAction();
		}

		public function prevPhotoAction() {
			$prevImg = $this->_dao->getPrevImage( $this->getImg() );
			$this->setImg( $prevImg );


			$this->photoAction();
		}

		public function nextPhotoAction() {
			$prevImg = $this->_dao->getNextImage( $this->getImg() );
			$this->setImg( $prevImg );

			$this->photoAction();
		}


		// ---------------------------------------------------------------------------------------------- Maker
		protected function makeMenu() {
			parent::makeMenu();

			$this->_menu[ 'First' ] = BASE_URL . "firstPhoto&imgId=" .
				$this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'Random' ] = BASE_URL . "randomPhoto&imgId=" .
				$this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'More' ] = BASE_URL . "morePhotoMatrix&imgId=" .
				$this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'Zoom +' ] = BASE_URL . "zoommorePhoto&imgId=" .
				$this->getImg()->getId() . "&size=" . $this->getSize();

			$this->_menu[ 'Zoom -' ] = BASE_URL . "zoomlessPhoto&imgId=" .
				$this->getImg()->getId() . "&size=" . $this->getSize();
		}

		protected function makeContent() {
			$this->_dataContent[ 'navBar' ] = [
				"Prev" => BASE_URL . 'prevPhoto&imgId=' .
					( $this->getImg()->getId() ) . '&size=' . $this->getSize(),

				"Next" => BASE_URL . 'nextPhoto&imgId=' .
					( $this->getImg()->getId() ) . '&size=' . $this->getSize()
			];
		}

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
		 * @param Image $img
		 */
		private function setImg( &$img ) {
			$this->_img = ( isset( $img ) && !empty( $img ) )
				? $img
				: $this->_dao->getFirstImage();
		}

		/**
		 * @return int
		 */
		public function getSize() {
			return $this->_size;
		}

		/**
		 * @param int $size
		 */
		private function setSize( &$size ) {
			$this->_size = (int) ( isset( $size ) )
				? htmlentities( $size )
				: MIN_WIDTH_PIC;
		}
	}
