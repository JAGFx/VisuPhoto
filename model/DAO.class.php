<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 22/10/2016
	 * Time: 11:46
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
		 * @param string $aQuery
		 * @param array  $aParams
		 *
		 * @return array
		 */
		public function execQuery( $aQuery, array $aParams ) {
			/*var_dump( $aQuery );
			var_dump( $aParams );*/

			$pQuery = $this->pdo->prepare( $aQuery );

			try {
				$pQuery->execute( $aParams );
				$rowCount = $pQuery->rowCount();

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
		 * @param string      $aQuery
		 * @param array       $aParams
		 * @param string|null $className
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
		 * @param string      $aQuery
		 * @param array       $aParams
		 * @param string|null $className
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
