<?php
	/**
	 * Created by PhpStorm.
	 * User: emsm
	 * Date: 15/10/2016
	 * Time: 13:59
	 */

	define( 'CHECK_CONFORMITY_FAIL_TITLE', "Valeur incorecte" );
	define( 'CHECK_CONFORMITY_FAIL_MESSAGE', "La valeur n'est pas défini" );
	define( 'CHECK_CONFORMITY_FAIL_CODE', 0 );

	define( 'INVALID_INT_TITLE', "Valeur non valide" );
	define( 'INVALID_INT_MESSAGE', "La valeur n'est pas un entier valide" );
	define( 'INVALID_INT_CODE', 1 );

	define( 'INVALID_BOOLEAN_TITLE', "Valeur non valide" );
	define( 'INVALID_BOOLEAN_MESSAGE', "La valeur n'est pas un booléen valide" );
	define( 'INVALID_BOOLEAN_CODE', 2 );

	define( 'INVALID_FLOAT_TITLE', "Valeur non valide" );
	define( 'INVALID_FLOAT_MESSAGE', "La valeur n'est pas un flotant valide" );
	define( 'INVALID_FLOAT_CODE', 3 );

	define( 'INVALID_STRING_TITLE', "Chaine de caractères non valide" );
	define( 'INVALID_STRING_MESSAGE', "La valeur n'est pas une chaine de caractères valide" );
	define( 'INVALID_STRING_CODE', 4 );

	define( 'INVALID_ARRAY_TITLE', "Tableau non valide" );
	define( 'INVALID_ARRAY_MESSAGE', "La valeur n'est pas un tableau valide" );
	define( 'INVALID_ARRAY_CODE', 12 );

	define( 'INVALID_EMAIL_TITLE', "Email non valide" );
	define( 'INVALID_EMAIL_MESSAGE', "La valeur n'est pas un email valide" );
	define( 'INVALID_EMAIL_CODE', 5 );

	define( 'REGEXP_TEL', '/^(\d{2}){5}$/' );
	define( 'INVALID_TEL_TITLE', "Numéro de téléphone non valide" );
	define( 'INVALID_TEL_MESSAGE', "La valeur n'est pas un numéro de téléphone valide" );
	define( 'INVALID_TEL_CODE', 6 );

	define( 'INVALID_URL_TITLE', "Adresse URL non valide" );
	define( 'INVALID_URL_MESSAGE', "La valeur n'est pas une adresse URL valide" );
	define( 'INVALID_URL_CODE', 7 );

	define( 'INVALID_IPV4_TITLE', "Adresse IPV4 non valide" );
	define( 'INVALID_IPV4_MESSAGE', "La valeur n'est pas une adresse IPV4 valide" );
	define( 'INVALID_IPV4_CODE', 8 );

	define( 'INVALID_IPV6_TITLE', "Adresse IPV6 non valide" );
	define( 'INVALID_IPV6_MESSAGE', "La valeur n'est pas une adresse IPV6 valide" );
	define( 'INVALID_IPV6_CODE', 9 );

	define( 'INVALID_MAC_TITLE', "Adresse MAC non valide" );
	define( 'INVALID_MAC_MESSAGE', "La valeur n'est pas une adresse MAC valide" );
	define( 'INVALID_MAC_CODE', 10 );

	define( 'REGEXP_DEC_DEGREE', '/^\d{1,3}(\.\d*)?$/' );
	define( 'INVALID_DEC_DEGREE_TITLE', "Coordonnée en degrès décimal non valide" );
	define( 'INVALID_DEC_DEGREE_MESSAGE', "La valeur n'est pas une coordonnée en degrès décimal valide" );
	define( 'INVALID_DEC_DEGREE_CODE', 11 );

	define( 'INVALID_UPLOAD_DEGREE_TITLE', "Coordonnée en degrès décimal non valide" );
	define( 'FU_ERR_INI_SIZE', "La taille du fichier téléchargé excède la valeur configurée sur le serveur" );
	define( 'FU_ERR_FORM_SIZE', "La taille du fichier téléchargé excède la valeur maximal spécifiée dans le formulaire HTML" );
	define( 'FU_ERR_PARTIAL', "Le fichier n'a été que partiellement téléchargé" );
	define( 'FU_ERR_NO_FILE', "Aucun fichier n'a été téléchargé" );
	define( 'FU_ERR_NO_TMP_DIR', "Un dossier temporaire est manquant" );
	define( 'FU_ERR_CANT_WRITE', "Échec de l'écriture du fichier sur le disque" );
	define( 'FU_ERR_EXTENSION', "Extension non supporté" );
