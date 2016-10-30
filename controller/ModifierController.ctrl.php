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
        // Génération de la vue
        if (UserSessionManager::hasPrivilege(UserSessionManager::USER_PRIVILEGE) or UserSessionManager::hasPrivilege(UserSessionManager::ADMIN_PRIVILEGE)) {
            $this->renderView(__FUNCTION__);
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

                if (empty($_POST['nouvelleCategorie'])) {
                    $newCategory = htmlentities($inputValidator->validateString($_POST['selectList']));
                } else {
                    $newCategory = htmlentities($inputValidator->validateString($_POST['nouvelleCategorie']));
                }

                $this->getDAO()->updateImage($newCategory, $newCommentaire, $imgId);

                echo "Mise à jour réussie";
            } catch (Exception $exc) {

                echo var_dump($exc->getMessage());

            }
        }
    }


    /**
     * Génération des données du contenu
     */
    protected function makeContent()
    {
        $this->_dataContent['navBar'] = [
            "Previous" => BASE_URL . 'prevPhoto&imgId=' .
                ($this->getImg()->getId()) . '&size=' . $this->getSize(),

            "Next" => BASE_URL . 'nextPhoto&imgId=' .
                ($this->getImg()->getId()) . '&size=' . $this->getSize(),
            "First" => BASE_URL . "firstPhoto&imgId=" .
                $this->getImg()->getId() . "&size=" . $this->getSize(),

            "Random" => BASE_URL . "randomPhoto&imgId=" .
                $this->getImg()->getId() . "&size=" . $this->getSize(),

            "list" => $this->getDAO()->getListCategory()
        ];

        $this->_dataContent['modifier'] = [
            "Button" => BASE_URL . 'viewModifier&imgId=' .
                ($this->getImg()->getId()) . '&size=' . $this->getSize()
        ];

    }

    /**
     * Convertis les données de class en un tableau
     *
     * @return array
     */
    protected function toData()
    {
        return [
            'img' => $this->_img,
            'menu' => $this->_menu,
            'size' => $this->_size
        ];
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