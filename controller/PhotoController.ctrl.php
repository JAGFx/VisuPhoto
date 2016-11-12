<?php

	/**
	 * Exemple pris: photoMatrixAction
	 *
	 * Les noms des méthodes action sont normalisées
	 *        - Première partie: Nom de la sous-vue (Ici "photoMatrix")
	 *        - Deuxième partie: "Action" Nécessaire pour définir une méthode "Action"
	 */

	use InputValidator\InputValidatorExceptions;

	/**
	 * Class PhotoController
	 *
	 * Contrôleur pour l'affichage d'une photo
	 */
	class PhotoController extends Controller {
		/**
		 * @var Image Image actuel
		 */
		private $_img;

		/**
		 * @var int Taille en hauteur maximal actuel
		 */
		private $_size;

		/**
		 * PhotoController constructor.
		 */
		public function __construct() {
			parent::__construct( 'ImageDAO' );

			// Récupération de l'image actuel si défini
			$img = ( isset( $_GET[ "imgId" ] ) )
				? $this->getDAO()->getImage( htmlentities( $_GET[ "imgId" ] ) )
				: null;

			$this->setImg( $img );
			$this->setSize( $_GET[ "size" ] );
		}

		// ---------------------------------------------------------------------------------------------- Actions
		/**
		 * Rendue de page par défaut
		 */
		public function photoAction() {
			// Création des variables de contenu
			$this->makeMenu();
			$this->makeContent();

			$this->getViewManager()->setValue(
				'url',
				BASE_URL . "zoommorePhoto&imgId=" . $this->getImg()->getId(
				) . "&size=" . $this->getSize()
			);


			// Génération de la vue
			$this->getViewManager()->render( 'Photo/photo' );
		}

		/**
		 * Traitement pour accèder à la première image
		 */
		public function firstPhotoAction() {
			// Traitement
			$firstImg = $this->getDAO()->getFirstImage();
			$this->setImg( $firstImg );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour accèder à une image aléatoirement
		 */
		public function randomPhotoAction() {
			// Traitement
			$randomImg = $this->getDAO()->getRandomImage();
			$this->setImg( $randomImg );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour zoomer l'image actuel
		 */
		public function zoommorePhotoAction() {
			// Traitement
			$ratio = $this->getSize() * MORE_RATIO;
			$this->setSize( $ratio );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour de-zoomer l'image actuel
		 */
		public function zoomlessPhotoAction() {
			// Traitement
			$ratio = $this->getSize() * LESS_RATIO;
			$this->setSize( $ratio );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour accèder à l'image précedente
		 */
		public function prevPhotoAction() {
			// Traitement
			$prevImg = $this->getDAO()->getPrevImage( $this->getImg() );
			$this->setImg( $prevImg );

			// Génération de la vue
			$this->photoAction();
		}

		/**
		 *
		 * Traitement pour voter sur une photo (si utilisateur connecté ou non)
		 * Si non connecté on regarde ses cookies et on l'autorise si il n'a pas voté
		 * Si connecté on regardé dans la base s'il n'a pas encore voté et on ajoute un cookie
		 *
		 */
		public function votePhotoAction() {
			$valueJug = $_GET[ "jug" ];
			$imgId    = $this->getImg()->getId();

            //Si l'utilisateur n'a pas de cookie
			if ( !isset( $_COOKIE[ 'votePhoto' . $imgId ] ) ) {

				$pseudo = UserSessionManager::getSession()->getPseudo();

                //Si l'utilisateur est connecté on regarde s'il n'a pas voté
                if (UserSessionManager::hasPrivilege(UserSessionManager::USER_PRIVILEGE)) {
					$retour = $this->getDAO()->checkvoteImage( $imgId, $pseudo );
				} else {
					$retour = null;
				}

                //Si l'utilisateur n'a pas encore voté
				if ( $retour == null ) {

					if ( $valueJug == LIKE_BUTTON or $valueJug == DISLIKE_BUTTON ) {

						try {
							$this->getDAO()->voteImage( $imgId, $valueJug, $pseudo );
                            //Création d'un cookie
							setcookie(
								"votePhoto" . $imgId, "A vote" . $valueJug,
								time() + 365 * 24 * 3600, null, null, false, true
							);

							echo toAjax(
								TYPE_FEEDBACK_SUCCESS,
								[
									'Titre'   => 'Merci pour votre vote',
									'Message' => "Vous pouvez continuer de parcourir notre album",
								]
							);

						} catch ( InputValidatorExceptions $ive ) {

							echo ivExceptionToAjax( (object) $ive->getError() );
						}
					}
				} else {
					echo toAjax(
						TYPE_FEEDBACK_ERROR,
						[
							'Titre'   => 'Vous avez déjà voté pour cette photo',
							'Message' => "Vous ne pouvez donc pas revoter pour celle-ci",
						]
					);

				}
			} else {
				echo toAjax(
					TYPE_FEEDBACK_ERROR,
					[
						'Titre'   => 'Vous avez déjà voté pour cette photo',
						'Message' => "Vous ne pouvez donc pas revoter pour celle-ci",
					]
				);

			}
            //Chargement de la vue
			$this->photoAction();
		}

		/**
		 * Traitement pour accèder à l'image suivante
		 */
		public function nextPhotoAction() {
			// Traitement
			$prevImg = $this->getDAO()->getNextImage( $this->getImg() );
			$this->setImg( $prevImg );

			// Génération de la vue
			$this->photoAction();
		}

        /**
         * Methode pour ajouter des photos dans la base si l'utilisateur est connecté
         */
		public function addPhotoAction() {
			if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
				if ( !empty( $_POST ) ) {
					$iv = new IValidatorVisu();

					try {
						$comment  = $iv->validateString( $_POST[ 'comment' ] );
						$ctge     = $iv->validateString( $_POST[ 'category' ] );
						$basePath = 'uploads/';

						// Si une URL est spécifié
						if ( isset( $_POST[ 'imageURL' ] ) && !empty( $_POST[ 'imageURL' ] ) )
							$path = $iv->validateURL( $_POST[ 'imageURL' ] );

						// Sinon upload un fichier local
						else {
							$file = $iv->moveFileUpload( $_FILES[ 'image' ], $basePath );
							$path = $basePath . $file[ 'name' ];
						}

						$this->getDAO()->addImage( $path, $ctge, $comment );

						// Notification de succès et redirection vers le tableau de bord
						echo toAjax(
							TYPE_FEEDBACK_SUCCESS,
							[
								'Titre'   => 'Ajout réussie',
								'Message' => "L'ajout de l'image à été effectué avec succès",
							]
						);

					} catch ( InputValidatorExceptions $ive ) {
						// L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
						echo ivExceptionToAjax( (object) $ive->getError() );
					}

				} else {
					$this->makeMenu();

					$this->getViewManager()
					     ->setPageView( 'Dashboard/base' )
					     ->setValue( 'listeCtge', $this->getDAO()->getListCategory() )
					     ->render( 'Photo/addPhoto' );
				}

			} else
				$this->redirectToRoute( 'loginUser' );
		}


		// ---------------------------------------------------------------------------------------------- Maker
		/**
		 * Génération des données du menu
		 */
		protected function makeMenu() {
			parent::makeMenu();

			$this->getViewManager()->setValue(
				'menuAdmin',
				[
					'Connexion'   => BASE_URL . "loginUser",
					'Inscription' => BASE_URL . "registerUser"
				]
			);
		}

		/**
		 * Génération des données du contenu
		 */
		protected function makeContent() {
			$this->getViewManager()->setValue(
				'navBar',
				[
					"Previous" => BASE_URL . 'prevPhoto&imgId=' .
						      ( $this->getImg()->getId() ) . '&size=' . $this->getSize(),

					"Next"  => BASE_URL . 'nextPhoto&imgId=' .
						   ( $this->getImg()->getId() ) . '&size=' . $this->getSize(),
					"First" => BASE_URL . "firstPhoto&imgId=" .
						   $this->getImg()->getId() . "&size=" . $this->getSize(),

					"Random" => BASE_URL . "randomPhoto&imgId=" .
						    $this->getImg()->getId() . "&size=" . $this->getSize(),

					"More" => BASE_URL . "morePhotoMatrix&imgId=" .
						  $this->getImg()->getId() . "&size=" . $this->getSize(),

					"Zoom +" => BASE_URL . "zoommorePhoto&imgId=" .
						    $this->getImg()->getId() . "&size=" . $this->getSize(),

					"Zoom -" => BASE_URL . "zoomlessPhoto&imgId=" .
						    $this->getImg()->getId() . "&size=" . $this->getSize(),

					"list" => $this->getDAO()->getListCategory(),

					"Popularite" => BASE_URL . "popularitePhotoMatrix&imgId=" .
							$this->getImg()->getId(
							) . "&nbImg=" . MIN_NB_PIC . "&size=" . $this->getSize(
						) . "&flt=" . "&popularite=true"
				]
			);

			$this->getViewManager()->setValue(
				'listCategoty', BASE_URL .
						"filtrebycategoryPhotoMatrix&imgId=" .
						$this->getImg()->getId() . "&nbImg=" . MIN_NB_PIC
						. "&flt="
			);

			$this->getViewManager()->setValue(
				'modifier',
				[
					"Button" => BASE_URL . 'viewModifier&imgId=' .
						    ( $this->getImg()->getId() ) . '&size=' . $this->getSize()
				]
			);

            $this->getViewManager()->setValue(
                'currentCategory', ""
            );

			$this->getViewManager()->setValue(
				'note',
				[
					"Like"     => BASE_URL . "votePhoto&imgId=" .
						      $this->getImg()->getId() . "&size=" . $this->getSize(
						) . "&jug=" . LIKE_BUTTON,
					"Dislike"  => BASE_URL . "votePhoto&imgId=" .
						      $this->getImg()->getId() . "&size=" . $this->getSize(
						) . "&jug=" . DISLIKE_BUTTON,
					"infoNote" => $this->getDAO()->infovoteImage( $this->getImg()->getId() )
				]
			);

			$this->getViewManager()->setValue( 'img', $this->_img );
			$this->getViewManager()->setValue( 'size', $this->_size );
		}


		// ---------------------------------------------------------------------------------------------- Getters / Setters
		/**
		 * @return Image
		 */
		public function getImg() {
			return $this->_img;
		}

		/**
		 * @param Image $img
		 */
		private function setImg( &$img ) {
			$this->_img = ( isset( $img ) && !empty( $img ) )
				? $img
				: $this->getDAO()->getFirstImage();
		}

		/**
		 * @return int
		 */
		public function getSize() {
			return $this->_size;
		}

		/**
		 * @param int $size
		 */
		private function setSize( &$size ) {
			$this->_size = (int) ( isset( $size ) )
				? htmlentities( $size )
				: MIN_WIDTH_PIC;
		}

		/**
		 * Non nécessaire. Utilisé pour caster l'objet DAO en ImageDAO pour l'IDE
		 *
		 * @return ImageDAO
		 */
		protected function getDAO() {
			return parent::getDAO();
		}
	}
