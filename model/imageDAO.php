<?php
	require __DIR__ . '/image.php';

	/**
	 * Class ImageDAO
	 */
	class ImageDAO {

		/**
		 * @var PDO
		 */
		private $pdo;


		function __construct() {

			$dsn = 'sqlite:model/imageDB.db'; // Data source name
			try {
				$this->pdo = new PDO( $dsn ); //$db est un attribut privé d'ImageDAO

			} catch ( PDOException $e ) {

				die ( "Erreur : " . $e->getMessage() );
			}
		}
		
		/**
		 * Retourne le nombre d'images référencées dans le DAO
		 *
		 * @return int
		 */
		function size() {
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
		
		/**
		 * Retourne un objet image correspondant à l'identifiant
		 *
		 * @param int $imgId
		 *
		 * @return Image|null
		 */
		function getImage( $imgId ) {

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
		 * Retourne une image au hazard
		 *
		 * @return Image|null
		 */
		function getRandomImage() {
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
		function getFirstImage() {
			return $this->getImage( 1 );
		}
		
		/**
		 * Retourne l'image suivante d'une image
		 *
		 * @param image $img
		 *
		 * @return image|null
		 */
		function getNextImage( image $img ) {
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
		function getPrevImage( image $img ) {
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
		function jumpToImage( image $img, $nb ) {
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
		function getImageList( image $img, $nb ) {
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
	
	# Test unitaire
	# Appeler le code PHP depuis le navigateur avec la variable test
	# Exemple : http://localhost/image/model/imageDAO.php?test
	if ( isset( $_GET[ "test" ] ) ) {
		echo "<H1>Test de la classe ImageDAO</H1>";
		$imgDAO = new ImageDAO();
		echo "<p>Creation de l'objet ImageDAO.</p>\n";
		echo "<p>La base contient " . $imgDAO->size() . " images.</p>\n";
		$img = $imgDAO->getFirstImage();
		echo "La premiere image est : " . $img->getPath() . "</p>\n";
		# Affiche l'image
		echo "<img src=\"" . $img->getPath() . "\"/>\n";
	}


