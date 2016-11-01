<?php
	require __DIR__ . '/../Image.class.php';
	use \InputValidator\InputValidatorExceptions;

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


		public function getListCategory() {

			$pQuery = $this->pdo->prepare( "SELECT category FROM image GROUP BY category" );

			try {
				$pQuery->execute();
				$data = $pQuery->fetchAll();

			} catch ( Exception $exc ) {
				var_dump( $exc->getMessage() );
				$data = null;

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
		 *
		 * Met à jour la catégorie et le commentaire d'une photo
		 *
		 * @param string $category
		 * @param string $commentaire
		 * @param int    $imgId
		 */

		public function updateImage( $category, $commentaire, $imgId ) {

			$pQuery = "UPDATE image set category=?,comment=? WHERE id=?";

			$param = [
				$category,
				$commentaire,
				$imgId
			];

			$this->execQuery( $pQuery, $param );
		}


		/**
		 * Ajoute dans la table vote un vote si l'utilisateur n'a pas encore voté pour la photo
		 *
		 * @param $imgId
		 * @param $valueJug
		 * @param $pseudo
		 */

		public function voteImage( $imgId, $valueJug, $pseudo ) {

			$pQuery = "INSERT INTO note(idPhoto,valueJug,pseudo) VALUES (?,?,?)";

			$params = [
				$imgId,
				$valueJug,
				$pseudo
			];

			$this->execQuery( $pQuery, $params );
		}

		public function checkvoteImage( $imgId, $pseudo ) {

			$pQuery = "SELECT * FROM note WHERE pseudo=? and idPhoto=?";

			$params = [
				$pseudo,
				$imgId
			];


			return $this->findOne( $pQuery, $params );
		}

        public function populariteImage(Image $img, $nbImage)
        {

            $pQuery = $this->pdo->prepare("SELECT image.id,AVG(valueJug) AS vote,path,category,comment FROM image LEFT OUTER JOIN note on image.id=note.idPhoto GROUP BY Image.id ORDER BY vote DESC LIMIT ?, ?");

            try {
                $pQuery->execute([$img->getId() - 1,
                    $nbImage]);
                $data = $pQuery->fetchAll(PDO::FETCH_CLASS, "Image");
            } catch (Exception $exc) {
                var_dump($exc->getMessage());
                $data = [];
            }

            return (!empty($data)) ? $data : [];

        }

        /**
         * Retounrne le nombre de like / dislike d'une photo
         * @param $imgId
         * @return null|object
         */


        public function infovoteImage($imgId)
        {

            $pQuery = "SELECT (SELECT count(*) FROM note WHERE idPhoto=? and valueJug=0) as Dislike, (SELECT count(*) FROM note WHERE idPhoto=? and valueJug=1) as Like";

            $param = [
                $imgId,
                $imgId
            ];

            return $this->findOne($pQuery, $param);
        }


		/**
		 * @param Image  $img
		 * @param string $filtre
		 * @param int    $nbImage
		 *
		 * @return Image[]
		 */
		public function filtreImage( Image $img, $filtre, $nbImage ) {

			$pQuery = $this->pdo->prepare( "SELECT * FROM image WHERE id >= ? AND category = ? LIMIT  ?" );


			try {
				$pQuery->execute(
					[
						$img->getId() - 1,
						$filtre,
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
		 * @param string $filter
		 *
		 * @return Image|null
		 */
		public function getRandomImage( $filter = null ) {

			if ( is_null( $filter ) ) {

				$nbFichiers = $this->size();

				$rand = rand( 1, $nbFichiers );

				//var_dump($nbFichiers, $rand);

				return $this->getImage( $rand );

			} else
				return $this->getRandomFilter( $filter );
		}


		public function getRandomFilter( $filter ) {
			$query  = 'SELECT * FROM image WHERE category = ?';
			$params = [
				$filter
			];

			$result  = $this->findAll( $query, $params, 'Image' );
			$keyRand = array_rand( $result );

			return $result[ $keyRand ];
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
		 * @param image  $img
		 * @param int    $nb
		 * @param string $filter
		 *
		 * @return Image|null
		 */
		public function jumpToImage( image $img, $nb, $filter = null ) {
			if ( is_null( $filter ) ) {
				$imgID = (int) $img->getId();

				if ( $imgID + $nb >= 1 && $imgID + $nb <= $this->size() )
					$img = $this->getImage( $imgID + $nb );

				return $img;

			} else
				return $this->jumpToImageFiltred( $img, $nb, $filter );
		}

		/**
		 * @param Image  $img
		 * @param int    $nb
		 * @param string $filter
		 *
		 * @return null|Image
		 */
		public function jumpToImageFiltred( Image $img, $nb, $filter ) {
			$filtredImg = $this->filtreImage( $img, $filter, $nb );

			$query  = 'SELECT * FROM image WHERE id > ? AND category = ? LIMIT 1';
			$params = [
				$filtredImg[ 0 ]->getId(),
				$filter
			];

			$result = $this->findOne( $query, $params, 'Image' );

			return ( is_null( $result ) ) ? $filtredImg[ 0 ] : $result;
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

		/**
		 * @return Image[]
		 */
		public function getFullImageList() {
			$query = 'SELECT * FROM image ORDER BY id';

			return $this->findAll( $query, [ ], 'Image' );
		}

		/**
		 * @param $path
		 * @param $ctge
		 * @param $comment
		 *
		 * @throws InputValidatorExceptions
		 */
		public function addImage( $path, $ctge, $comment ) {
			$query  = 'INSERT INTO image( path, category, comment ) VALUES ( ?, ?, ? )';
			$params = [
				$path,
				$ctge,
				$comment
			];

			$result = (Object) $this->execQuery( $query, $params );
			if ( !$result->success )
				throw new InputValidatorExceptions(
					"Ajout impossible",
					$result->message,
					TYPE_FEEDBACK_WARN
				);
		}
	}
