<?php

	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 22/10/2016
	 * Time: 11:46
	 */

	require __DIR__ . '/DAOConstants.php';

	/**
	 * Class DAO
	 *
	 * Classe offrant des interaction de base avec un SGBD
	 */
	class DAO {
		/**
		 * SGBD de tpye MySQL
		 */
		const _DAO_SGBD_MYSQL = 0;

		/**
		 * SGBD de type PostgerSQL
		 */
		const _DAO_SGBD_PGSQL = 1;

		/**
		 * SGBD de type SQLite
		 */
		const _DAO_SGBD_SQLITE = 2;

		/**
		 * Hôte de la BDD
		 */
		const _HOST = DB_HOST;

		/**
		 * Nom d'utilisateur pour la connexion à la BDD
		 */
		const _LOGIN = DB_LOGIN;

		/**
		 * Mot de passe de connexion à la BDD
		 */
		const _PSWD = DB_PSWD;

		/**
		 * Nom de la BDD
		 */
		const _DBNAME = DB_DBNAME;

		/**
		 * Port de l'hôte BDD
		 */
		const _PORT = DB_PORT;

		/**
		 * Type d'encodage de la BDD
		 */
		const _CHARSET = DB_CHARSET;

		/**
		 *  Type de SGBD
		 */
		const _SGBD = DB_SGBD;

		/**
		 * @var PDO
		 */
		protected $pdo;

		/**
		 * @var array Tableau d'options pour PDO
		 */
		private $_options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		];


		/**
		 * DAO constructor.
		 */
		public function __construct() {
			$fullDSN = $this->getDSN();

			try {
				$this->pdo = new PDO(
					$fullDSN,
					self::_LOGIN,
					self::_PSWD,
					$this->_options
				);

			} catch ( PDOException $e ) {
				echo 'Fail to connect database : ' . $e->getMessage();
			}
		}

		/**
		 * Vérifie les paramètres de connexiion et génère le DSN pour le bon SGBD
		 *
		 * @return string DSN
		 * @throws \Exception
		 */
		private function getDSN() {
			// ---------------------------------------------------- Test connection params
			if ( is_null( self::_SGBD ) )
				throw new Exception( "Undefined SGBD", EXCPT_UNDEFINED_SGBD );

			elseif ( empty( self::_HOST ) && self::_SGBD !== self::_DAO_SGBD_SQLITE )
				throw new Exception( "Undefined host", EXCPT_UNDEFINED_HOST );

			elseif ( empty( self::_LOGIN ) && self::_SGBD !== self::_DAO_SGBD_SQLITE )
				throw new Exception( "Undefined login", EXCPT_UNDEFINED_LOGIN );

			elseif ( empty( self::_DBNAME ) )
				throw new Exception( "Undefined database name", EXCPT_UNDEFINED_DBNAME );


			// ---------------------------------------------------- Set full DSN for PDO Object
			if ( self::_SGBD === self::_DAO_SGBD_MYSQL ) {
				$fullDSN = 'mysql:host=[host]; dbname=[dbname]';

				if ( !is_null( self::_PORT ) )
					$fullDSN .= ' port=[port];';

				if ( !is_null( self::_CHARSET ) ) {
					$fullDSN .= ' charset=[charset]';
					$this->_options[ PDO::MYSQL_ATTR_INIT_COMMAND ] = "SET NAMES utf8";
				}

			} elseif ( self::_SGBD === self::_DAO_SGBD_PGSQL )
				$fullDSN = 'pgsql:host=[host]; dbname=[dbname]';

			elseif ( self::_SGBD === self::_DAO_SGBD_SQLITE )
				$fullDSN = 'sqlite:[dbname]';

			else
				throw new Exception( "Unsupported or inccorect SGBD", EXCPT_UNSUPPORTED_SGBD );

			$search = [
				'[host]',
				'[dbname]',
				'[port]',
				'[charset]'
			];

			$replace = [
				self::_HOST,
				self::_DBNAME,
				self::_PORT,
				self::_CHARSET
			];

			return str_replace( $search, $replace, $fullDSN );
		}

		/**
		 * Génère les objets si ceux-ci ne sont que partiellement générés avec PDO
		 *
		 * @param object[]|object|null $data Résultat de requête
		 *
		 * @return object[]|object|null Tableau d'objet
		 */
		public function objectMaker( $data ) {
			if ( is_array( $data ) ) {
				$entities = [ ];

				foreach ( $data as $entity )
					$entities[] = $this->make( $entity );

				return $entities;

			} else
				return $this->make( $data );
		}

		/**
		 * Création d'un objet
		 *
		 * @param object|null $object Objet retourné par PDO
		 *
		 * @return object|null
		 */
		protected function make( $object ) {
			return $object;
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

			$pQuery     = $this->pdo->prepare( $aQuery );
			$execResult = [ ];

			try {
				$pQuery->execute( $aParams );
				$rowCount = $pQuery->rowCount();

				// Message en cas de nombre de ligne null
				if ( $rowCount <= 0 )
					$execResult[ 'message' ] = $pQuery->errorInfo()[ 2 ];

			} catch ( Exception $exc ) {
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
					: $pQuery->fetchAll( PDO::FETCH_CLASS );

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

			$pQuery->closeCursor();

			return ( empty( $data ) ) ? null : $data;
		}
	}
