<?php
	namespace InputValidator;

	use \ErrorException;

	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 15/10/2016
	 * Time: 13:40
	 */
	class InputValidatorExceptions extends ErrorException {
		private $_title;

		/**
		 * InputValidatorExceptions constructor.
		 *
		 * @param string $title
		 * @param string $message
		 * @param int    $code
		 * @param int    $severity
		 */
		public function __construct( $title, $message, $code = 0, $severity = 1 ) {
			$this->_title = $title;

			parent::__construct( $message, $code, $severity );
		}

		/**
		 * @return array
		 */
		public function getError() {
			return [
				'title'   => $this->_title,
				'message' => $this->message,
				'code'    => $this->code
			];
		}


	}
