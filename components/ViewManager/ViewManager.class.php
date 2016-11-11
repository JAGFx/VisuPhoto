<?php

	/**
	 * Created by PhpStorm.
	 *
	 * @author: SMITH Emmanuel
	 *        Date: 02/11/2016
	 *        Time: 20:17
	 */
	final class ViewManager {
		/**
		 * @var array Données transmise à la vue
		 */
		private $_data;
		/**
		 * @var string Nom du template Principale
		 */
		private $_pageView = null;


		/**
		 * Ajoute une valeur aux données de la vue
		 *
		 * @param string $key   Nom de l'indexe de la valeur
		 * @param mixed  $value Valeur
		 *
		 * @return ViewManager $this
		 */
		public function setValue( $key, $value ) {
			if ( is_array( $value ) ) {
				$this->_data[ $key ] = ( isset( $this->_data[ $key ] ) ) ? $this->_data[ $key ] : [ ];
				$this->_data[ $key ] = array_merge( $value, $this->_data[ $key ] );

			} else
				$this->_data[ $key ] = $value;

			return $this;
		}

		/**
		 * Prépare et affiche les données dans la vues
		 *
		 * @param string $contentView Nom de la vue
		 *
		 * @return ViewManager $this
		 * @throws Exception
		 */
		public function render( $contentView ) {
			$pathContentView = __DIR__ . '/../../view/' . $contentView . '.view.php';
			if ( !is_file( $pathContentView ) )
				throw new Exception( ERR_INVALID_VIEW_NAME . ' : ' . $contentView );

			$pathPageView = __DIR__ . '/../../view/' . $this->_pageView . '.view.php';
			if ( !is_file( $pathContentView ) )
				throw new Exception( ERR_INVALID_VIEW_NAME . ' : ' . $this->_pageView );

			$this->setValue( 'view', $pathContentView );
			$data = (Object) $this->_data;

			require $pathPageView;

			return $this;
		}


		/**
		 * @return string
		 */
		public function getPageView() {
			return $this->_pageView;
		}


		/**
		 * @param string $pageView
		 *
		 * @return ViewManager  $this
		 */
		public function setPageView( $pageView ) {
			$this->_pageView = $pageView;

			return $this;
		}

	}
