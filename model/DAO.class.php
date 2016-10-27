<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 22/10/2016
	 * Time: 11:46
	 */

	/**
	 * Class DAO
	 *
	 * Classe offrant des interaction de base avec un SGBD
	 */
	class DAO {
		/**
		 * @var PDO
		 */
		protected $pdo;


		public function __construct() {

			$dsn = 'sqlite:model/imageDB.db'; // Data source name
			try {
				$this->pdo = new PDO( $dsn ); //$db est un attribut privé d'ImageDAO

			} catch ( PDOException $e ) {

				die ( "Erreur : " . $e->getMessage() );
			}
		}

		/**
		 * Execute une requête ne nécessitant pas de résultat
		 *
		 * @param string $aQuery
		 * @param array  $aParams
		 *
		 * @return array Variable de succès et / ou message en cas d'erreur
		 */
		public function execQuery( $aQuery, array $aParams ) {
			/*var_dump( $aQuery );
			var_dump( $aParams );*/

			$pQuery = $this->pdo->prepare( $aQuery );

			try {
				$pQuery->execute( $aParams );
				$rowCount = $pQuery->rowCount();

				// Message en cas de nombre de ligne null
				if ( $rowCount <= 0 )
					$execResult[ 'message' ] = $pQuery->errorInfo()[ 2 ];

			} catch ( Exception $exc ) {
				var_dump( $exc );
				$rowCount = 0;
			}

			$pQuery->closeCursor();

			$execResult[ 'success' ] = ( $rowCount > 0 ) ? true : false;

			return $execResult;
		}

		/**
		 * Execute une requête de recherche pour l'ensemble des correspondances (Mode objet)
		 *
		 * @param string      $aQuery
		 * @param array       $aParams
		 * @param string|null $className Nom de la class objet ou null si Objet neutre
		 *
		 * @return array|object[]
		 */
		public function findAll( $aQuery, array $aParams, $className = null ) {
			/*var_dump( $aQuery );
			var_dump( $aParams );*/

			$pQuery = $this->pdo->prepare( $aQuery );

			try {
				$pQuery->execute( $aParams );
				$data = ( !is_null( $className ) && class_exists( $className ) )
					? $pQuery->fetchAll( PDO::FETCH_CLASS, $className )
					: $pQuery->fetchAll();

			} catch ( Exception $exc ) {
				$data = [ ];
			}
			//var_dump( $data );

			$pQuery->closeCursor();

			return ( empty( $data ) ) ? [ ] : $data;
		}

		/**
		 * Execute une requête de recherche pour une correspondances (Mode objet)
		 *
		 * @param string      $aQuery
		 * @param array       $aParams
		 * @param string|null $className Nom de la class objet ou null si Objet neutre
		 *
		 * @return object|null
		 */
		public function findOne( $aQuery, array $aParams, $className = null ) {
			/*var_dump( $aQuery );
			var_dump( $aParams );*/

			$pQuery = $this->pdo->prepare( $aQuery );

			try {
				$pQuery->execute( $aParams );
				$data = ( !is_null( $className ) && class_exists( $className ) )
					? $pQuery->fetchObject( $className )
					: $pQuery->fetchObject();

			} catch ( Exception $exc ) {
				$data = null;
			}
			//var_dump( $data );

			$pQuery->closeCursor();

			return ( empty( $data ) ) ? null : $data;
		}
	}
