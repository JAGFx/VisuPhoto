<?php
	// FIXME To Delete

	// Etat de l'interface
	// Recupère l'identifiant de l'image courante
	if ( isset( $_GET[ "imgId" ] ) ) {
		$imgId = $_GET[ "imgId" ];
	} else {
		// c'est une erreur d'appel de ce calcul
		trigger_error( "Etat identifiant de l'image absent" );
	}

	$size = ( isset( $_GET[ "size" ] ) )
		? $_GET[ "size" ]
		: MIN_WIDTH_PIC;
	
	// Parametre de l'action
	if ( isset( $_GET[ "zoom" ] ) ) {
		$zoom = $_GET[ "zoom" ];
	} else {
		// c'est une erreur d'appel de ce calcul
		trigger_error( "Parametre zoom absent" );
	}
	
	// Calcule la nouvelle taille
	$size *= $zoom;

	// Retourne dans le mode d'affichage d'une image
	header( "Location: " . BASE_URL . "viewPhoto&imgId=$imgId&size=$size" );
