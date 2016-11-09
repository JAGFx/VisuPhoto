<?php


use InputValidator\InputValidator;
use InputValidator\InputValidatorExceptions;

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 30/10/2016
 * Time: 10:11
 */
class ModifierController extends Controller
{

    /**
     * @var Image Image actuel
     */
    private $_img;

    /**
     * @var int Taille en hauteur maximal actuel
     */
    private $_size;

    /**
     * ModifierController constructor.
     *
     */
    public function __construct()
    {
        parent::__construct('ImageDAO');

        // Récupération de l'image actuel si défini
        $img = (isset($_GET["imgId"]))
            ? $this->getDAO()->getImage(htmlentities($_GET["imgId"]))
            : null;

        $this->setImg($img);
        $this->setSize($_GET["size"]);
    }

    /**
     * Rendue de page par défaut
     */
    public function modifierAction()
    {
	    $this->makeMenu();
	    $this->makeContent();

        // Génération de la vue
	    if ( UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE ) ) {
		    $this->getViewManager()->render( 'Modifier/modifier' );
        } else {
            echo "Merci de vous connecter";
        }
    }

    /**
     * Fonction de mise à jour des données d'une photo
     */

    public function updateModifierAction()
    {

        $inputValidator = new InputValidator();
        if (!empty($_POST)) {

            try {

                $imgId = $this->getImg()->getId();
                $newCommentaire = htmlentities($inputValidator->validateString($_POST['commentaire']));

                //On regarde si l'utilisateur veur ajouter une catégorie
                if (empty($_POST['nouvelleCategorie'])) {
                    $newCategory = htmlentities($inputValidator->validateString($_POST['selectList']));
                } else {
                    $newCategory = htmlentities($inputValidator->validateString($_POST['nouvelleCategorie']));
                }

                $this->getDAO()->updateImage($newCategory, $newCommentaire, $imgId);

                echo toAjax(
                    TYPE_FEEDBACK_SUCCESS,
                    [
                        'Titre' => 'Mise à jour réussie',
                        'Message' => 'Vous pouvez continuer vos modifications !',
                    ]

                );
            } catch (InputValidatorExceptions $ive) {
                echo ivExceptionToAjax((object)$ive->getError());
            }
        }
    }


    /**
     * Génération des données du contenu
     */
    protected function makeContent()
    {
        //Création des données pour la navBar
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

			    "list" => $this->getDAO()->getListCategory()
		    ]
	    );


        $this->getViewManager()->setValue(
		    'listCategoty',
		    BASE_URL . "filtrebycategoryPhotoMatrix&imgId=" .
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

	    $this->getViewManager()->setValue( 'img', $this->_img );
	    $this->getViewManager()->setValue( 'size', $this->_size );
    }


    // ---------------------------------------------------------------------------------------------- Getters / Setters
    /**
     * @return Image
     */
    public function getImg()
    {
        return $this->_img;
    }

    /**
     * @param &Image $img
     */
    private function setImg(&$img)
    {
        $this->_img = (isset($img) && !empty($img))
            ? $img
            : $this->getDAO()->getFirstImage();
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * @param &int $size
     */
    private function setSize(&$size)
    {
        $this->_size = (int)(isset($size))
            ? htmlentities($size)
            : MIN_WIDTH_PIC;
    }

    /**
     * Non nécessaire. Utilisé pour caster l'objet DAO en ImageDAO pour l'IDE
     *
     * @return ImageDAO
     */
    protected function getDAO()
    {
        return parent::getDAO();
    }

}