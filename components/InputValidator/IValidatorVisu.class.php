<?php
	require_once __DIR__ . '/dist/InputValidator.php';
	use InputValidator\InputValidator;
	use InputValidator\InputValidatorExceptions;
	
	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 30/10/2016
	 *        Time: 15:41
	 */
	class IValidatorVisu extends InputValidator {

		/**
		 * @param $str
		 *
		 * @return string
		 * @throws InputValidatorExceptions
		 */
		public function &validateString( &$str ) {
			$str = parent::validateString( $str );

			if ( empty( $str ) )
				throw new InputValidatorExceptions(
					"Chaine vide",
					"La valeur de la chaine est vide",
					TYPE_FEEDBACK_WARN
				);

			return $str;
		}

		/**
		 * @param       $file
		 * @param       $path
		 * @param array $type
		 * @param int   $size
		 *
		 * @return mixed
		 * @throws \InputValidator\InputValidatorExceptions
		 */
		public function &moveFileUpload( &$file, &$path, array &$type = [ ], &$size = -1 ) {
			$path = $this->validateString( $path );

			$base = __DIR__ . '/../../' . $path;

			if ( !file_exists( $base ) )
				mkdir( $base, 707 );

			$file = $this->validateFileUploaded( $file, $type, $size );
			$move = move_uploaded_file( $file[ 'tmp_name' ], $base . $file[ 'name' ] );
			if ( !$move )
				throw new InputValidatorExceptions(
					"Téléchargement impossible",
					"Impossible d'uploader l'image",
					TYPE_FEEDBACK_ERROR
				);

			return $file;
		}

		/**
		 * @param $str1
		 * @param $str2
		 *
		 * @throws \InputValidator\InputValidatorExceptions
		 */
		public function validateSameString( &$str1, &$str2 ) {
			$str1 = $this->validateString( $str1 );
			$str2 = $this->validateString( $str2 );

			if ( $str1 !== $str2 )
				throw new InputValidatorExceptions(
					'Mot de passe différents',
					'Les deux mots de passe saisis sont différents.',
					TYPE_FEEDBACK_WARN
				);
		}
		
	}