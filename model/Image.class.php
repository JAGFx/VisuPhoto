<?php

	# Notion d'image
	/**
	 * Class Image
	 */
	final class Image {
		/**
		 * Chemin depuis la rachine jusqu'au dossier image
		 */
		const BASE_PATH = 'model/imgs/';

		/**
		 * @var string Chemin de l'image depuis la base
		 */
		private $path = "";
		/**
		 * @var int ID unique
		 */
		private $id = 0;
		/**
		 * @var string Catégorie
		 */
		private $category;
		/**
		 * @var string Commentaire
		 */
		private $comment;

		/**
		 * Image constructor.
		 */
		function __construct() { }

		# Retourne l'URL de cette image
		/**
		 * @return string
		 */
		public function getPath() {
			return self::BASE_PATH . $this->path;
		}

		/**
		 * @return int
		 */
		public function getId() {
			return (int) $this->id;
		}

		/**
		 * @return string
		 */
		public function getCategory() {
			return $this->category;
		}

		/**
		 * @return string
		 */
		public function getComment() {
			return $this->comment;
		}


	}


