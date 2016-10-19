<?php

	class AProposController extends Controller {


		/**
		 * AProposController constructor.
		 *
		 * @param ImageDAO $_dao
		 */
		public function __construct( ImageDAO $_dao ) {
			parent::__construct( $_dao );
		}

		public function aProposAction() {
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
