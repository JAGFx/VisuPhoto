<?php
	require __DIR__ . '/../Album.class.php';
	use InputValidator\InputValidatorExceptions;

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 31/10/2016
	 *        Time: 18:03
	 */
	class AlbumDAO extends DAO {

		/**
		 * Création d'un objet
		 *
		 * @param object|null $albumIN Objet retourné par PDO
		 *
		 * @return Album|null
		 */
		protected function make( $albumIN ) {
			if ( !is_null( $albumIN ) ) {

				$imgDAO  = loadDAO( 'ImageDAO' );
				$userDAO = loadDAO( 'UserDAO' );

				$alb = new Album( $albumIN->id, $albumIN->name, $userDAO->findUser( $albumIN->owner ) );

				foreach ( explode( ',', $albumIN->images ) as $imgID )
					$alb->addImage( $imgDAO->getImage( $imgID ) );

			} else
				$alb = null;

			return $alb;
		}


		/**
         * Methode pour ajouter des albums dans la base de données
         *
         * @param Album $album
         * @throws InputValidatorExceptions
         */
		public function addAlbum( Album $album ) {
			$query = 'INSERT INTO album( name, owner, images ) VALUES ( ?, ?, ? )';
			$params = [
				$album->getName(),
				$album->getOwner()->getPseudo(),
				$album->getImageString()
			];

			$result = (Object) $this->execQuery( $query, $params );

			if ( !$result->success )
				throw new InputValidatorExceptions(
					"Impossible d'ajouter l'album",
					$result->message,
					TYPE_FEEDBACK_DANGER
				);
		}

        /**
         *
         * Mise à jour d'un album dans la base de données
         * @param Album $album
         * @throws InputValidatorExceptions
         */
		public function editAlbum( Album $album ) {
			$query = 'UPDATE album SET name = ?, owner = ?, images = ? WHERE id = ?';
			$params = [
				$album->getName(),
				$album->getOwner()->getPseudo(),
				$album->getImageString(),
				$album->getId()
			];

			$result = (Object) $this->execQuery( $query, $params );

			if ( !$result->success )
				throw new InputValidatorExceptions(
					"Impossible de modifer l'album",
					$result->message,
					TYPE_FEEDBACK_DANGER
				);
		}

        /**
         *
         * Suppression d'un album de la base de données
         *
         * @param Album $album
         * @throws InputValidatorExceptions
         */
		public function removeAlbum( Album $album ) {
			$query = 'DELETE FROM album WHERE id = ?';
			$params = [
				$album->getId()
			];

			$result = (Object) $this->execQuery( $query, $params );

			if ( !$result->success )
				throw new InputValidatorExceptions(
					"Impossible de supprimer l'album",
					$result->message,
					TYPE_FEEDBACK_DANGER
				);
		}

		/**
		 * @param User $user
		 *
		 * @return Album[]
		 * @throws Exception
		 */
		public function findListAlbumByUser( User $user ) {
			$query = 'SELECT * FROM album WHERE owner = ?';
			$params = [
				$user->getPseudo()
			];

			$result = $this->findAll( $query, $params );

			return $this->objectMaker( $result );
		}

        /**
         *
         * Fonction de recherche d'album pour un id donné ( retourne album)
         *
	 * @param int $id
	 *
*@return Album
         * @throws InputValidatorExceptions
         */
		public function findAlbumById( $id ) {
			$query = 'SELECT * FROM album WHERE id = ?';
			$params = [
				$id
			];

			$result = $this->findOne( $query, $params );

			return $this->objectMaker( $result );
		}

		public function findListAlbum() {
			$query = 'SELECT * FROM album';

			$result = $this->findAll( $query, [ ] );

			return $this->objectMaker( $result );
		}
	}