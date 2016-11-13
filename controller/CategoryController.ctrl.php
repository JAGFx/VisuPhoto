<?php

/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 13/11/2016
 * Time: 10:30
 */
class CategoryController extends Controller
{

    private $_name;


    public function __construct()
    {
        parent::__construct('ImageDAO');

        $name = (isset($_GET["catName"]))
            ? htmlentities($_GET["catName"])
            : null;

        $this->setName($name);


    }

    // ---------------------------------------------------------------------------------------------- Actions
    public function viewListCategoryAction()
    {

        if (UserSessionManager::hasPrivilege(UserSessionManager::USER_PRIVILEGE)) {
            $this->makeMenu();
            $this->makeContent();

            $listCategory = $this->getDAO()->getListCategory();


            $this->getViewManager()
                ->setPageView('Dashboard/base')
                ->setValue('listCategory', $listCategory)
                ->render('Photo/listCategory');

        } else
            $this->redirectToRoute('loginUser');

    }

    public function makeContent()
    {

    }

    public function deleteCategoryAction()
    {

        if (UserSessionManager::hasPrivilege(UserSessionManager::USER_PRIVILEGE)) {
            try {
                $this->getDAO()->deletecategoryImage($this->getName());
                $this->redirectToRoute('viewlistCategory');

            } catch (InputValidatorExceptions $ive) {
                // L'une des données utilisateur n'est pas du bon type ou sont incorrectes, notification utilisateur
                echo ivExceptionToAjax((object)$ive->getError());
            }

        } else
            $this->redirectToRoute('loginUser');

    }

    /**
     * Génération des données du menu
     * Méthode factorisé à tous les Contrôleur. Indique les menu minimaux
     */
    protected function makeMenu()
    {
        parent::makeMenu();

        $this->getViewManager()->setValue(
            'menuAdmin',
            [
                'Connexion' => BASE_URL . "loginUser",
                'Inscription' => BASE_URL . "registerUser"
            ]
        );
    }

    /**
     * @return ImageDAO|null
     */
    protected function getDAO()
    {
        return parent::getDAO();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }
}