<?php

	# Notion d'image
	class Image {
		const BASE_PATH = 'model/imgs/';

		private $path = "";
		private $id   = 0;
		private $category;
		private $comment;

		function __construct() { }

		# Retourne l'URL de cette image
		public function getPath() {
			return self::BASE_PATH . $this->path;
		}

		public function getId() {
			return (int) $this->id;
		}

		/**
		 * @return mixed
		 */
		public function getCategory() {
			return $this->category;
		}

		/**
		 * @return mixed
		 */
		public function getComment() {
			return $this->comment;
		}


	}


