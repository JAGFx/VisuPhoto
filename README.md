# VisuPhoto

Projet en Licence Mi-AW

Sujet: Application de visualisation de photos

Octobre - Novembre 2016

## Note
Ceci ne remplace pas la documentation. Elle permet d'avoir des application concrêtre des notions.

## Notions
### UserSessionManager
> Privilège: Entier permettant de déterminer le droit d'accès à une ressource

Il existe 3 types de privilège:

* `NO_PRIVILEGE`

* `USER_PRIVILEGE`

* `ADMIN_PRIVILEGE`

Par défaut, un utilisateur dispose du privilège `USER_PRIVILEGE`.

La session est initié dans le `frontal.ctrl` avec le privilège `NO_PRIVILEGE`.

#### Utilisation
##### Verifier qu'un utilisateur est connecté

````php
// hasPrivilege() vérifie que la session dispose du bon privilège
UserSessionManager::hasPrivilege( UserSessionManager::USER_PRIVILEGE )
````

##### Création d'une session utilisateur

````php
// renew() met un terme à la session et en crée une nouvelle avec l'utilisateur passé en paramètre 
UserSessionManager::renew( $user )
````

##### Récupération de l'utilisateur

````php
// getSession() renvoi un objet User de l'utilisateur courrant.
// /!\ Le mot de passe n'est pas conservé pour des raisons évidente.
UserSessionManager::getSession()
````



### DAO
Le DAO est caratérisé par 3 méthodes:

* `execQuery( $aQuery, array $aParams ) ` : Execute une requête sans attente de résultat (`INSERT, UPDATE, DELETE`)

* `findAll( $aQuery, array $aParams, $className = null )` : Execute une requête pour trouver toutes les occurences (`SELECT`)

* `findOne( $aQuery, array $aParams, $className = null ) ` : Execute une requête pour trouver une seul occurence (`SELECT`)

#### Utilisation
##### ExecQuery()
###### Explication
Cette méthode renvoie un tableau de résultat, il contient:

* Une variable de succès

* Un message associé en cas d'échec

######Exemple 
````php
    /* Fichier: /model/DAO/UserDAO.dao.php - Méthode addUser()  */

    $query  = 'INSERT INTO user VALUES(?, ?, ?)';
    $params = [
        $user->getPseudo(),
        $user->getPassword(),
        $user->getPrivilege()
    ];
    
    $result = $this->execQuery( $query, $params );
    
    /*
        Resultat type :
        [
            'success'   => bool,
            'message'   => string|null
        ]
    */
````

##### findAll()
###### Explication
Cette méthode renvoie un ensemble d'occurence sous forme d'objet

Le paramètre `$className` défini le type d'objet à créer. Si `null`, ce sera des objets anonymes

Le retour est dans tous les cas soit un tableau d'objet, soit un tableau vide

###### Exemple
Voir `execQuery()`


##### findOne()
###### Explication
Cette méthode renvoie une occurence sous forme d'objet

Le paramètre `$className` défini le type d'objet à créer. Si `null`, ce sera un objet anonyme

Le retour est dans tous les cas soit l'objet, soit `NULL`.

###### Exemple
Voir `execQuery()`



### FormJS
Voir le `README` dans [`/view/Default/assets/lib/formJS`](https://github.com/JAGFx/VisuPhoto/tree/master/view/Default/assets/lib/formsJS)


### InputValidator
Voir le `README` dans [`/components/InputValidator`](https://github.com/JAGFx/VisuPhoto/tree/master/components/InputValidator/dist)
