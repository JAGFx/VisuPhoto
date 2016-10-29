<?php
	require __DIR__ . '/../Image.class.php';

	/**
	 * Class ImageDAO
	 */
	class ImageDAO extends DAO {

		/**
		 * Retourne le nombre d'images référencées dans le DAO
		 *
		 * @return int
		 */
		public function size() {
			$pQuery = $this->pdo->prepare( "SELECT COUNT (*) FROM image" );

			try {
				$pQuery->execute();
				$data = $pQuery->fetch()[ 0 ];

			} catch ( Exception $exc ) {
				var_dump( $exc->getMessage() );
				$data = 0;
			}

			return $data;
		}



		public function getListCategory(){

			$pQuery=$this->pdo->prepare("SELECT category FROM image GROUP BY category");

			try{
				$pQuery->execute();
				$data=$pQuery->fetchAll();

			}

			catch(Exception $exc){
				var_dump($exc->getMessage());
				$data=null;

			}

			return ( !empty( $data ) ) ? $data : null;
		}
		
		/**
		 * Retourne un objet image correspondant à l'identifiant
		 *
		 * @param int $imgId
		 *
		 * @return Image|null
		 */
		public function getImage( $imgId ) {

			$pQuery = $this->pdo->prepare( "SELECT * FROM image WHERE id = ?" );


			try {
				$pQuery->execute( [ $imgId ] );
				$data = $pQuery->fetchObject( 'Image' );
			} catch ( Exception $exc ) {
				var_dump( $exc->getMessage() );
				$data = null;
			}

			return ( !empty( $data ) ) ? $data : null;
		}


		/**
		 * @param Image  $img
		 * @param string $filtre
		 * @param int    $nbImage
		 *
		 * @return Image[]
		 */
		public function filtreImage( Image $img, $filtre, $nbImage ) {

			$pQuery = $this->pdo->prepare( "SELECT * FROM image WHERE category = ? LIMIT  ?,?" );


			try {
				$pQuery->execute(
					[
						$filtre,
						$img->getId(),
						$nbImage
					]
				);
				$data = $pQuery->fetchAll( PDO::FETCH_CLASS, "Image" );
			} catch ( Exception $exc ) {
				var_dump( $exc->getMessage() );
				$data = [ ];
			}

			return ( !empty( $data ) ) ? $data : [ ];
		}
		
		
		/**
		 * Retourne une image au hazard
		 *
		 * @return Image|null
		 */
		public function getRandomImage() {
			$nbFichiers = $this->size();

			$rand = rand( 1, $nbFichiers );

			//var_dump($nbFichiers, $rand);

			return $this->getImage( $rand );
		}
		
		/**
		 * Retourne l'objet de la premiere image
		 *
		 * @return Image|null
		 */
		public function getFirstImage() {
			return $this->getImage( 1 );
		}
		
		/**
		 * Retourne l'image suivante d'une image
		 *
		 * @param image $img
		 *
		 * @return image|null
		 */
		public function getNextImage( image $img ) {
			$id = $img->getId();
			if ( $id < $this->size() ) {
				$img = $this->getImage( $id + 1 );
			}

			return $img;
		}
		
		/**
		 * Retourne l'image précédente d'une image
		 *
		 * @param image $img
		 *
		 * @return image|null
		 */
		public function getPrevImage( image $img ) {
			$id = $img->getId();
			if ( $id > 1 ) {
				$img = $this->getImage( $id - 1 );
			}

			return $img;
		}

		/**
		 * Retourne la nouvelle image
		 * saute en avant ou en arrière de $nb images
		 *
		 * @param image $img
		 * @param int   $nb
		 *
		 * @return image|null
		 */
		public function jumpToImage( image $img, $nb ) {
			$imgID = (int) $img->getId();

			if ( $imgID + $nb >= 1 && $imgID + $nb <= $this->size() )
				$img = $this->getImage( $imgID + $nb );

			return $img;
		}
		

		/**
		 * Retourne la liste des images consécutives à partir d'une image
		 *
		 * @param image $img
		 * @param int   $nb
		 *
		 * @return Image[]
		 */
		public function getImageList( image $img, $nb ) {
			$res = [ ];

			# Verifie que le nombre d'image est non nul
			if ( !$nb > 0 ) {
				debug_print_backtrace();
				trigger_error( "Erreur dans ImageDAO.getImageList: nombre d'images nul" );
			}
			$id  = $img->getId();
			$max = $id + $nb;
			while ( $id < $this->size() && $id < $max ) {
				$res[] = $this->getImage( $id );
				$id++;
			}

			return $res;
		}
	}
