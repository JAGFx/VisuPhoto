<?php
	
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 19/10/2016
	 * Time: 20:55
	 */
	abstract class Controller {
		protected $_dao;
		protected $_menu;

		/**
		 * Controller constructor.
		 *
		 * @param ImageDAO $_dao
		 */
		protected function __construct( ImageDAO $_dao ) {
			$this->_dao = $_dao;
		}

		/**
		 *
		 */
		protected function makeMenu() {
			$this->_menu[ 'Home' ]     = "./";
			$this->_menu[ 'A propos' ] = BASE_URL . "viewAPropos";
		}

		/**
		 * @return mixed
		 */
		protected abstract function makeContent();

		/**
		 * @return mixed
		 */
		protected abstract function toData();

		protected function showView( $fx ) {
			$this->makeMenu();
			$this->makeContent();

			$className    = str_replace( 'Controller', '', get_class( $this ) );
			$functionName = str_replace( 'Action', '', $fx );

			$data = $this->toData();
			$path = __DIR__ . '/../view/' . $className . '/' . $functionName . '.view.php';
			require $path;
		}
	}