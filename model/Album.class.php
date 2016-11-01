<?php
	
	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 31/10/2016
	 *        Time: 18:11
	 */
	class Album {
		/**
		 * @var int
		 */
		private $_id;

		/**
		 * @var string
		 */
		private $_name;

		/**
		 * @var Image[]
		 */
		private $_images;

		/**
		 * @var User
		 */
		private $_owner;

		/**
		 * Album constructor.
		 *
		 * @param int    $_id
		 * @param string $_name
		 * @param User   $_owner
		 */
		public function __construct( $_id, $_name, User $_owner ) {
			$this->_id    = $_id;
			$this->_name  = $_name;
			$this->_owner = $_owner;
		}

		/**
		 * @return int
		 */
		public function getId() {
			return $this->_id;
		}

		/**
		 * @return string
		 */
		public function getName() {
			return $this->_name;
		}

		/**
		 * @return Image[]
		 */
		public function getImages() {
			return $this->_images;
		}

		/**
		 * @return string
		 */
		public function getImageString() {
			$str = '';

			foreach ( $this->_images as $img )
				$str .= $img->getId() . ',';

			return substr( $str, 0, -1 );
		}

		/**
		 * @param Image $img
		 */
		public function addImage( Image $img ) {
			$this->_images[] = $img;
		}

		/**
		 * @param Image $img
		 */
		public function removeImage( Image $img ) {
			foreach ( $this->_images as $k => $image )
				if ( $image->getId() === $img->getId() ) {
					unset( $this->_images[ $k ] );
					break;
				}
		}

		/**
		 * @return User
		 */
		public function getOwner() {
			return $this->_owner;
		}


	}