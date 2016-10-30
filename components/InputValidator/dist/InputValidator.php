<?php
	namespace InputValidator;

	require __DIR__ . '/InputConstants.php';
	require __DIR__ . '/InputValidatorExceptions.php';

	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 15/10/2016
	 * Time: 13:21
	 */
	class InputValidator {

		/**
		 * InputValidator constructor.
		 */
		public function __construct() {
		}

		/**
		 * @param $value
		 *
		 * @return mixed
		 * @throws InputValidatorExceptions
		 */
		protected function checkConformity( &$value ) {
			if ( !isset( $value ) )
				throw new InputValidatorExceptions(
					CHECK_CONFORMITY_FAIL_MESSAGE,
					CHECK_CONFORMITY_FAIL_TITLE,
					CHECK_CONFORMITY_FAIL_CODE
				);

			return $value;
		}


		/**
		 * @param $value
		 *
		 * @return int
		 * @throws InputValidatorExceptions
		 */
		public function &validateInt( &$value ) {
			$conformity = $this->checkConformity( $value );

			if ( !is_int( $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_INT_TITLE,
					INVALID_INT_MESSAGE,
					INVALID_INT_CODE
				);

			return $conformity;
		}

		/**
		 * @param $bool
		 *
		 * @return bool
		 * @throws InputValidatorExceptions
		 */
		public function &validateBoolean( &$bool ) {
			$conformity = $this->checkConformity( $bool );

			if ( !is_bool( $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_BOOLEAN_TITLE,
					INVALID_BOOLEAN_MESSAGE,
					INVALID_BOOLEAN_CODE
				);

			return $conformity;
		}

		/**
		 * @param $float
		 *
		 * @return float
		 * @throws InputValidatorExceptions
		 */
		public function &validateFloat( &$float ) {
			$conformity = $this->checkConformity( $float );

			if ( !is_float( $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_FLOAT_TITLE,
					INVALID_FLOAT_MESSAGE,
					INVALID_FLOAT_CODE
				);

			return $conformity;
		}

		/**
		 * @param $str
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateString( &$str ) {
			$conformity = $this->checkConformity( $str );

			if ( !is_string( $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_STRING_TITLE,
					INVALID_STRING_MESSAGE,
					INVALID_STRING_CODE
				);

			return $conformity;
		}

		/**
		 * @param $array
		 *
		 * @return array
		 * @throws InputValidatorExceptions
		 */
		public function &validateArray( &$array ) {
			$conformity = $this->checkConformity( $array );

			if ( !is_array( $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_ARRAY_TITLE,
					INVALID_ARRAY_MESSAGE,
					INVALID_ARRAY_CODE
				);

			return $conformity;
		}

		/**
		 * @param $email
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateEmail( &$email ) {
			$conformity = $this->checkConformity( $email );

			if ( !filter_var( $conformity, FILTER_VALIDATE_EMAIL ) )
				throw new InputValidatorExceptions(
					INVALID_EMAIL_TITLE,
					INVALID_EMAIL_MESSAGE,
					INVALID_EMAIL_CODE
				);

			return $conformity;
		}

		/**
		 * @param $tel
		 *
		 * @return mixed
		 * @throws InputValidatorExceptions
		 */
		public function &validateTel( &$tel ) {
			$conformity = $this->checkConformity( $tel );

			if ( !preg_match( REGEXP_TEL, $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_TEL_TITLE,
					INVALID_TEL_MESSAGE,
					INVALID_TEL_CODE
				);

			return $conformity;
		}

		/**
		 * @param $url
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateURL( &$url ) {
			$conformity = $this->checkConformity( $url );

			if ( !filter_var( $conformity, FILTER_VALIDATE_URL ) )
				throw new InputValidatorExceptions(
					INVALID_URL_TITLE,
					INVALID_URL_MESSAGE,
					INVALID_URL_CODE
				);

			return $conformity;
		}

		/**
		 * @param $ip
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateIPV4( &$ip ) {
			$conformity = $this->checkConformity( $ip );

			if ( !filter_var( $conformity, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) )
				throw new InputValidatorExceptions(
					INVALID_IPV4_TITLE,
					INVALID_IPV4_MESSAGE,
					INVALID_IPV4_CODE
				);

			return $conformity;
		}

		/**
		 * @param $ip
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateIPV6( &$ip ) {
			$conformity = $this->checkConformity( $ip );

			if ( !filter_var( $conformity, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) )
				throw new InputValidatorExceptions(
					INVALID_IPV6_TITLE,
					INVALID_IPV6_MESSAGE,
					INVALID_IPV6_CODE
				);

			return $conformity;
		}

		/**
		 * @param $mac
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateMAC( &$mac ) {
			$conformity = $this->checkConformity( $mac );

			if ( !filter_var( $conformity, FILTER_VALIDATE_MAC ) )
				throw new InputValidatorExceptions(
					INVALID_MAC_TITLE,
					INVALID_MAC_MESSAGE,
					INVALID_MAC_CODE
				);

			return $conformity;
		}

		/**
		 * @param float $decD
		 *
		 * @return float
		 * @throws InputValidatorExceptions
		 */
		public function &validateDecimalDegree( &$decD ) {
			$conformity = $this->checkConformity( $decD );

			if ( !preg_match( REGEXP_DEC_DEGREE, $conformity ) )
				throw new InputValidatorExceptions(
					INVALID_DEC_DEGREE_TITLE,
					INVALID_DEC_DEGREE_MESSAGE,
					INVALID_DEC_DEGREE_CODE
				);

			return $conformity;
		}

		/**
		 * @param string $file
		 * @param array  $type
		 * @param int    $size
		 *
		 * @return mixed
		 * @throws InputValidatorExceptions
		 */
		public function &validateFileUploaded( &$file, array &$type = [ ], &$size = -1 ) {
			$fileValid = $this->checkConformity( $file );
			$typeValid = $this->validateArray( $type );
			$sizeValid = $this->validateInt( $size );

			$fileUploadErrors = [
				UPLOAD_ERR_INI_SIZE   => FU_ERR_INI_SIZE,
				UPLOAD_ERR_FORM_SIZE  => FU_ERR_FORM_SIZE,
				UPLOAD_ERR_PARTIAL    => FU_ERR_PARTIAL,
				UPLOAD_ERR_NO_FILE    => FU_ERR_NO_FILE,
				UPLOAD_ERR_NO_TMP_DIR => FU_ERR_NO_TMP_DIR,
				UPLOAD_ERR_CANT_WRITE => FU_ERR_CANT_WRITE,
				UPLOAD_ERR_EXTENSION  => FU_ERR_EXTENSION,
			];

			if ( $fileValid[ 'error' ] > UPLOAD_ERR_OK )
				throw new InputValidatorExceptions(
					INVALID_UPLOAD_DEGREE_TITLE,
					$fileUploadErrors[ $fileValid[ 'error' ] ],
					$fileValid[ 'error' ]
				);

			elseif ( !empty( $typeValid ) && !in_array( $fileValid[ 'type' ], $typeValid ) )
				throw new InputValidatorExceptions(
					INVALID_UPLOAD_DEGREE_TITLE,
					$fileUploadErrors[ UPLOAD_ERR_EXTENSION ],
					UPLOAD_ERR_EXTENSION
				);

			elseif ( $sizeValid > -1 && $fileValid[ 'size' ] > $sizeValid )
				throw new InputValidatorExceptions(
					INVALID_UPLOAD_DEGREE_TITLE,
					$fileUploadErrors[ UPLOAD_ERR_FORM_SIZE ],
					UPLOAD_ERR_FORM_SIZE
				);


			return $fileValid;
		}
	}
