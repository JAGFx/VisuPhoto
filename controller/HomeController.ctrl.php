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
		 */
		public function __construct() {
			parent::__construct();
		}

		public function homeAction() {
			$this->renderView( __FUNCTION__ );
		}

		protected function makeMenu() {
			parent::makeMenu();
			$this->_menu[ 'Voir photos' ] = BASE_URL . 'viewPhoto';
		}

		protected function makeContent() {
		}

		protected function toData() {
			return [
				'menu' => $this->_menu
			];
		}
	}
