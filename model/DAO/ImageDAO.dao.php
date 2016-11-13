<?php
	require __DIR__ . '/../Image.class.php';
	use \InputValidator\InputValidatorExceptions;

	/**
	 * Class ImageDAO
	 */
	class ImageDAO extends DAO {

		/**
		 * Retourne la liste des catégories
		 *
		 * @return array|\object[]
		 */
		public function getListCategory() {
			$query = 'SELECT category FROM image GROUP BY category';

			return $this->findAll( $query, [ ] );
		}
		
		/**
		 * Retourne un objet image correspondant à l'identifiant
		 *
		 * @param int $imgId
		 *
		 * @return Image|null
		 */
		public function getImage( $imgId ) {
			$query  = 'SELECT * FROM image WHERE id = ?';
			$params = [
				$imgId
			];

			return $this->findOne( $query, $params, 'Image' );
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
		 * Supprime une catégorie
		 *
		 * @param string $catName
		 *
		 * @throws \InputValidator\InputValidatorExceptions
		 */
		public function deletecategoryImage( $catName ) {
			$pQuery = "UPDATE image set category='vide' WHERE category=?";

			$param = [
				$catName
			];

			$res = (Object) $this->execQuery( $pQuery, $param );

			if ( !$res->success )
				throw new InputValidatorExceptions(
					"Suppression impossible",
					$res->message,
					TYPE_FEEDBACK_WARN
				);
		}


		/**
		 * Ajoute dans la table vote un vote si l'utilisateur n'a pas encore voté pour la photo
		 *
		 * @param integer $imgId
		 * @param int     $valueJug
		 * @param string  $pseudo
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

		/**
		 * Methode permettant de regarder si une personne a voté sur une photo
		 *
		 * @param int    $imgId
		 * @param String $pseudo
		 *
		 * @return null|object
		 */
		public function checkvoteImage( $imgId, $pseudo ) {
			$pQuery = "SELECT * FROM note WHERE pseudo=? and idPhoto=?";

			$params = [
				$pseudo,
				$imgId
			];

			return $this->findOne( $pQuery, $params );
		}

		/**
		 * Methode qui permet de trier les photos par la popularité ( moyenne des votes)
		 *
		 * @param Image $img
		 * @param int   $nbImage
		 *
		 * @return array
		 */
		public function populariteImage( Image $img, $nbImage ) {
			$query = 'SELECT image.id, AVG( valueJug ) AS vote, path, category, comment
				FROM image
				LEFT OUTER JOIN note
				ON image.id=note.idPhoto
				GROUP BY Image.id
				ORDER BY vote DESC
				LIMIT ? ,?';

			$params = [
				$img->getId() - 1,
				$nbImage
			];

			return $this->findAll( $query, $params, 'Image' );
		}

		/**
		 * Retounrne le nombre de like / dislike d'une photo
		 *
		 * @param integer $imgId
		 *
		 * @return null|object
		 */


		public function infovoteImage( $imgId ) {
			$pQuery = "SELECT (
						SELECT count(*)
						FROM note
						WHERE idPhoto = ?
							AND valueJug=0 ) as Dislike,
						( SELECT count(*)
						FROM note
						WHERE idPhoto = ?
							AND valueJug=1) as Like";

			$param = [
				$imgId,
				$imgId
			];

			return $this->findOne( $pQuery, $param );
		}


		/**
		 * @param Image  $img
		 * @param string $filtre
		 * @param int    $nbImage
		 *
		 * @return Image[]
		 */
		public function filtreImage( Image $img, $filtre, $nbImage ) {
			$pQuery = 'SELECT * FROM image WHERE id > ? AND category = ? LIMIT  ?';
			$params = [
				$img->getId() - 1,
				$filtre,
				$nbImage
			];

			return $this->findAll( $pQuery, $params, 'Image' );
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

				$query = 'SELECT * FROM image ORDER BY RANDOM() LIMIT 1';

				return $this->findOne( $query, [ ], 'Image' );
			} else
				return $this->getRandomFilter( $filter );
		}


		/**
		 * @param string $filter
		 */
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
		 * @param null $filtre
		 * @param int  $nb
		 *
		 * @return Image|null
		 */
		public function getFirstImage( $filtre = null, $nb = 1 ) {
			if ( !empty( $filtre ) )
				return $this->filtreImage( new Image(), $filtre, $nb )[ 0 ];

			else
				return $this->getImage( 1 );
		}

		/**
		 * Retourne la dernière image
		 *
		 * @return null|Image
		 */
		public function getLastImage() {
			$query = 'SELECT * FROM image ORDER BY id DESC LIMIT 1, 1';

			return $this->findOne( $query, [ ], 'Image' );
		}

		/**
		 * Retourne la dernière image d'une catégorie
		 *
		 * @param string $filtre
		 *
		 * @return null|Image
		 */
		public function getLastImageFiltre( $filtre ) {
			$query  = 'SELECT * FROM image WHERE category = ? ORDER BY id DESC LIMIT 1';
			$params = [
				$filtre
			];

			return $this->findOne( $query, $params, 'Image' );
		}

		/**
		 * Retourne la dernière image populaire
		 *
		 * @return null|Image
		 */
		public function getLastImagePop() {
			$query = 'SELECT image.id,AVG(valueJug) AS vote,path,category,comment FROM image LEFT OUTER JOIN note on image.id=note.idPhoto GROUP BY Image.id ORDER BY vote LIMIT 1';

			return $this->findOne( $query, [ ], 'Image' );
		}
		
		/**
		 * Retourne l'image suivante d'une image
		 *
		 * @param Image $img
		 *
		 * @return Image|null
		 */
		public function getNextImage( Image $img ) {
			$query  = 'SELECT * FROM image WHERE id > ? ORDER BY id LIMIT 1';
			$params = [
				$img->getId()
			];

			return $this->findOne( $query, $params, 'Image' );
		}
		
		/**
		 * Retourne l'image précédente d'une image
		 *
		 * @param Image $img
		 *
		 * @return Image|null
		 */
		public function getPrevImage( Image $img ) {
			$query  = 'SELECT * FROM image WHERE id < ? ORDER BY id DESC LIMIT 1';
			$params = [
				$img->getId()
			];

			return $this->findOne( $query, $params, 'Image' );
		}

		/**
		 * Retourne la nouvelle image
		 * saute en avant ou en arrière de $nb images
		 *
		 * @param Image  $img
		 * @param int    $nb
		 * @param string $filter
		 *
		 * @return Image|null
		 */
		public function jumpToImage( Image $img, $nb, $filter = null ) {
			if ( is_null( $filter ) ) {
				$query  = ( $nb >= 0 )
					? 'SELECT * FROM image WHERE id > ? ORDER BY id LIMIT ?, 1'
					: 'SELECT * FROM image WHERE id < ? ORDER BY id DESC LIMIT ?, 1';
				$params = [
					$img->getId(),
					abs( $nb ) - 1,
				];

				return $this->findOne( $query, $params, 'Image' );

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
			$query  = ( $nb >= 0 )
				? 'SELECT * FROM image WHERE id > ? AND category = ? ORDER BY id LIMIT ?, 1'
				: 'SELECT * FROM image WHERE id < ? AND category = ? ORDER BY id DESC LIMIT ?, 1';
			$params = [
				$img->getId(),
				$filter,
				abs( $nb )
			];

			$result = $this->findOne( $query, $params, 'Image' );

			return $result;
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
			$query  = 'SELECT * FROM image  WHERE id > ? ORDER BY id LIMIT ?';
			$params = [
				$img->getId(),
				$nb
			];

			$res = $this->findAll( $query, $params, 'Image' );

			return $res;
		}

		/**
		 * Retourne toutes les images
		 *
		 * @return Image[]
		 */
		public function getFullImageList() {
			$query = 'SELECT * FROM image ORDER BY id';

			return $this->findAll( $query, [ ], 'Image' );
		}

		/**
		 * Ajoute une image dans la BDD
		 *
		 * @param        $path
		 * @param string $ctge
		 * @param string $comment
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
