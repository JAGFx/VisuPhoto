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
			$albums = [ ];
			$imgDAO = loadDAO( 'ImageDAO' );
			$userDAO = loadDAO( 'UserDAO' );

			foreach ( $result as $album ) {
				$album = (Object) $album;

				$alb = new Album( $album->id, $album->name, $userDAO->findUser( $album->owner ) );

				foreach ( explode( ',', $album->images ) as $imgID )
					$alb->addImage( $imgDAO->getImage( $imgID ) );

				$albums[] = $alb;
			}

			return $albums;
		}

		public function findAlbumById( $id ) {
			$query = 'SELECT * FROM album WHERE id = ?';
			$params = [
				$id
			];

			$result = $this->findOne( $query, $params );
			$imgDAO = loadDAO( 'ImageDAO' );
			$userDAO = loadDAO( 'UserDAO' );

			if ( is_null( $result ) )
				throw new InputValidatorExceptions(
					"Impossible de supprimer l'album",
					"L'album est déjà supprimé",
					TYPE_FEEDBACK_DANGER
				);

			$alb = new Album( $result->id, $result->name, $userDAO->findUser( $result->owner ) );

			foreach ( explode( ',', $result->images ) as $imgID )
				$alb->addImage( $imgDAO->getImage( $imgID ) );

			return $alb;
		}

		public function findListAlbum() {
			$query = 'SELECT * FROM album';

			$result = $this->findAll( $query, [ ] );
			$albums = [ ];
			$imgDAO = loadDAO( 'ImageDAO' );
			$userDAO = loadDAO( 'UserDAO' );

			foreach ( $result as $album ) {
				$album = (Object) $album;

				$alb = new Album( $album->id, $album->name, $userDAO->findUser( $album->owner ) );

				foreach ( explode( ',', $album->images ) as $imgID )
					$alb->addImage( $imgDAO->getImage( $imgID ) );

				$albums[] = $alb;
			}

			return $albums;
		}
	}