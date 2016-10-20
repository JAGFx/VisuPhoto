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
		protected $_dataContent;

		/**
		 * Controller constructor.
		 *
		 * @param ImageDAO $_dao
		 */
		protected function __construct( ImageDAO $_dao ) {
			$this->_dao = $_dao;
			$this->_dataContent = [ ];
		}

		/**
		 *
		 */
		protected function makeMenu() {
			$this->_menu[ 'Home' ] = "./";
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

		/**
		 * @param $fx
		 */
		protected function renderView( $fx ) {
			$this->makeMenu();
			$this->makeContent();

			$className = str_replace( 'Controller', '', get_class( $this ) );
			$functionName = str_replace( 'Action', '', $fx );
			$path = __DIR__ . '/../view/' . $className . '/' . $functionName . '.view.php';

			$data = (Object) array_merge(
				$this->toData(),
				$this->_dataContent,
				[
					'view' => $path
				]
			);

			require __DIR__ . '/../view/Default/default.view.php';
		}
	}