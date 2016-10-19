<?php

	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 19/10/2016
	 * Time: 20:27
	 */
	class HomeController extends Controller {


		/**
		 * AProposController constructor.
		 *
		 * @param ImageDAO $_dao
		 */
		public function __construct( ImageDAO $_dao ) {
			parent::__construct( $_dao );
		}

		public function homeAction() {
			$this->showView( __FUNCTION__ );
		}

		protected function makeMenu() {
			parent::makeMenu();
			$this->_menu[ 'Voir photos' ] = BASE_URL . 'viewPhoto';
		}

		protected function makeContent() {
		}

		protected function toData() {
			return (Object) [
				'menu' => $this->_menu
			];
		}
	}
