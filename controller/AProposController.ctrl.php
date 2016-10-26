<?php

	class AProposController extends Controller {


		/**
		 * AProposController constructor.
		 *
		 */
		public function __construct() {
			parent::__construct();
		}

		public function aProposAction() {
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
