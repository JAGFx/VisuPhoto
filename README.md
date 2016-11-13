# VisuPhoto

[![Build Status](https://scrutinizer-ci.com/g/JAGFx/VisuPhoto/badges/build.png?b=master)](https://scrutinizer-ci.com/g/JAGFx/VisuPhoto/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JAGFx/VisuPhoto/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JAGFx/VisuPhoto/?branch=master)


Projet en Licence Mi-AW

Sujet: Application de visualisation de photos

Octobre - Novembre 2016

## Note
Ceci ne remplace pas la documentation. Elle permet d'avoir des application concrêtre des notions.

## Fonctionnalités
Demandé: 

* Affichage d'image et détails (Seul, Groupe)

* Naviguation dans les images (Seul, Groupe)

* Gestion d'album d'images

* Gestion de jugement d'images

* Filtrage par catégorie

* Compte utilisateur

Supplémentaire:

* Modification du profil

* Liste des photo jugé dans le tableau de bord

## Structure du projet

Le projet repose sur une architecture MVC. L’interface utilisateur et les interactions des objets avec une base de données sont séparée.
Dossiers:

* `assets` : Regroupe de tous les fichiers de style (CSS et JavaScript) + image servant uniquement à ces fichiers. Est inclus les différentes librairies telles que Bootstrap ou JQuery

* `components` : Regroupe l'ensemble des outils utilisé pour ce projet (InputValidatoir, Controller, DAO, etc ...)

* `controller` : Regroupe tous les contrôleurs du projet

* `model` : Regroupe toutes les classes objets et fichiers de base de données (`*.db`)

* `model/DAO` : Regroupe tous les DAO permettant l'interaction Objet <> Base de données

* `view` : Regroupe toutes les interfaces utilisateurs

## Configuration

Le fichier `controller/commons.php` contient les constantes utilisé dans le projet. Parmis eux

* Valeurs de ratio de zoom, taille minimal, url de base, etc ...

* Paramètres de la DAO (Hôte, login, mot de passe, nom de la BDD, SGBD, port et encodage)

Droit d'écriture nécessaire sur les éléments suivant:

* VisuPhoto/model/imgs/uploads

* VisuPhoto/model/imageDB.db

## Principe
Le projet est fait de tel sorte à ce qu'il y ai qu'un seul point d'entré. Le fichier `index.php` est le point d'entré de l'application. Il inclu le contrôleur Frontal.

Url valide: `http://path/to/VisuPhoto/?s=viewPhoto`

Tous accès à tout autre fichiers ou dossier hors `assets` sera interdit et retournera une `Error 401`

Compte utilisateur mise à disposition: 
> Login:                emmauel
> Mot de passe:     pswd

#### Utilisation
A l'arrivé sur le `Frontal contrôleur` il charge et créé le contrôleur correspondant à l'action demmandé

##### Charger un contrôleur

La première partie en minuscule uniquement correspond à l'action

La partie qui suit correspond au nom du Contrôleur

Action à l'entré de contrôleur frontal: `zoomPhotoMatrix`

* Action: `zoom`

* Contrôleur: `PhotoMatrix`

````php
    // Récupère l'action dans l'url
    $action = ( isset( $_GET[ 'a' ] ) ) ? htmlentities( $_GET[ 'a' ] ) : null;
    
    // Charge le contrôleur
    $controller = loadController( $action );
````


##### Charger un DAO

````php
    // Charge le DAO "ImageDAO"
    $imgDAO = loadDAO( 'ImageDAO' );
````


## Outils
### Controller
Cette classe abstraite est étendus par tous les contrôleurs du projet. Elle englobe les fonctionnalités suivantes:

* Chargement du DAO

* Instanciation du ViewManager

* Redirection vers une autre action (Et donc un autre contrôleur)

* Factorisation des donées communes à tous les contrôleurs (Menu)


### ViewManager
La `ViewManager` permet de gérer les vues distinctement du contrôleur. C'est plus flexible.

Il est uniquement accessible et créer depuis un contrôleur. 

Il exite 3 actions:

* Ajout de valeur

* Définition du template principale

* Rendue

#### Utilisation
##### Définir un template principale

Répertoire d'entré pour définir une vue: `/view`

Dossier de la vue: Répertoire entité. Ex: `Dashboard`

Nom du fichier de vue: Nom du fichier sans `.view.html|php`. Ex: `base`


````php
    /* Fichier /controller/AlbumController.ctrl.php - Méthode viewListAlbumAction()  */
    
    // Défini un template principal Dashboard.
    $this->getViewManager()->setPageView( 'Dashboard/base' );

````

##### Ajout de valeur
Il existe deux comportement:

* Ajout d'une valeur (Objet, entier, flottant, string, etc ...)

* Ajout d'un tableau

Pour l'ajout de valeur, celle-ci est créer si inexistante, remplacé sinon.

Pour l'ajout de tableau, celui-ci est créer si inexistant, fusionné sinon.

````php
    /* Fichier /controller/AlbumController.ctrl.php - Méthode viewListAlbumAction()  */
    
    // Défini une valeur $listAlbum indexé par une clé "listAlbum"
    $this->getViewManager()->setValue( 'listAlbum', $listAlbum );

````

##### Rendue d'une vue

Nom de la vue, voir `Définir un template principale`

````php
    /* Fichier /controller/AlbumController.ctrl.php - Méthode viewListAlbumAction()  */
    
    // Affiche la vue est effectue les traitement avec les données
    $this->getViewManager()->render( 'Album/listAlbum' );

````


### UserSessionManager
Cette classe permet la gestion d'une session utilisateur. Elle nécessite la classe `User.class.php` pour fonctionné puisqu'elle en sérialise / désérialise une partie 

> Privilège: Entier permettant de déterminer le droit d'accès à une ressource

Il existe 3 types de privilège:

* `NO_PRIVILEGE`

* `USER_PRIVILEGE`

* `ADMIN_PRIVILEGE`

Par défaut, un utilisateur dispose du privilège `USER_PRIVILEGE`.

Un utilisateur avec le privilège `ADMIN_PRIVILEGE` dispose aussi du privilège `USER_PRIVILEGE`

La session est initié dans le `frontal.ctrl` avec le privilège `NO_PRIVILEGE`.

#### Utilisation
##### Initialiser une session utilisateur

````php
    // init() : Effectue un session_start()
    // start() : Génère la session avec un utilisateur "Invité"
    UserSessionManager::init();
	UserSessionManager::start();
````

##### Verifier qu'un utilisateur est connecté

````php
    // hasPrivilege() vérifie que la session dispose du bon privilège
    UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE );
````

##### Création d'une session utilisateur

````php
    // renew() met un terme à la session et en crée une nouvelle avec l'utilisateur passé en paramètre 
    UserSessionManager::renew( $user );
````

##### Récupération de l'utilisateur

````php
    // getSession() renvoi un objet User de l'utilisateur courrant.
    // /!\ Le mot de passe n'est pas conservé pour des raisons évidente.
    UserSessionManager::getSession();
````



### DAO
Le constructeur de la classe détermine le type de SGBD et instencie une objet PDO avec celui-ci.
Le DAO est auto-configuré avec les constantes renseignés dans `commons.php`.
Il existe 3 type de méthodes:

* `execQuery( $aQuery, array $aParams ) ` : Execute une requête sans attente de résultat (`INSERT, UPDATE, DELETE`)

* `findAll( $aQuery, array $aParams, $className = null )` : Execute une requête pour trouver toutes les occurences (`SELECT`)

* `findOne( $aQuery, array $aParams, $className = null ) ` : Execute une requête pour trouver une seul occurence (`SELECT`)

#### Utilisation
##### Exécuter une requête sans résultat

````php
    /* Fichier: /model/DAO/UserDAO.dao.php - Méthode addUser()  */

    // Requête : INSERT, UPDATE, DELETE
    $query  = 'INSERT INTO user VALUES(?, ?, ?)';
    
    // Paramètres de la requête
    $params = [
        $user->getPseudo(),
        $user->getPassword(),
        $user->getPrivilege()
    ];
    
    // Exécution et retour de résultat d'exécution
    $result = $this->execQuery( $query, $params );
    
    /*
        Resultat type :
        [
            'success'   => bool,
            'message'   => string|null
        ]
    */
````

##### Trouver toutes les occurrences

````php
    // Requête de séléction
    $query = 'SELECT * FROM image WHERE category = ? ORDER BY id';
    
    // Paramètres si nécessaire
    $params = [
        $category
    ];
    
    // Retour d'un tableau d'objet ou un tableau vide.
    // "Image" défini le type d'objet à créer. Si non spécifié, c'est des stdObject qui sont crées
    $result = $this->findAll( $query, $params, 'Image' );
````


##### Trouver une occurrence

````php
    // Requête de séléction
    $query = 'SELECT * FROM image WHERE id = ?';
    
    // Paramètres si nécessaire
    $params = [
        $id
    ];
    
    // Retour d'un objet ou NULL
    // "Image" défini le type d'objet à créer. Si non spécifié, c'est un stdObject qui est crée
    $result = $this->findOne( $query, $params, 'Image' );
````



### FormJS
Voir le [`README`](https://github.com/JAGFx/FormJS)


### InputValidator
Voir le [`README`](https://github.com/JAGFx/InputValidator)
