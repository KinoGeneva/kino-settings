<?php 

function kino_test_fields() {

	// Permet de définir les numéros de champs xprofile à tester 
	// dans un unique endroit!

	$kino_fields = array();
	
	
	$kino_fields['profile-role'] = 135; // Profil Kinoite Role
	$kino_fields['kabaret'] = 100; // Participe au cabaret 2016?
	$kino_fields['role-kabaret'] = 1258; // Test des rôles pour le Kabaret 2016
	
	// Les trois options des rôles pour le Kabaret 2016
	$kino_fields['role-kabaret-comed'] = '1458_0';
	$kino_fields['role-kabaret-tech'] = '1459_1';
	$kino_fields['role-kabaret-real'] = '1460_2';
	
	// Les champs Choix de Session pour le Kabaret 2016
	$kino_fields['session-un'] = 1101;
	$kino_fields['session-deux'] = 1106;
	$kino_fields['session-trois'] = 1116;
	
	// Bénévoles
	$kino_fields['benevole'] = 1313; // Aide Bénévole?
	$kino_fields['benevole-kabaret'] = 1320; // Pour quelles activités
	$kino_fields['benevole-fonction'] = 1327; // Pour quelles charges
	$kino_fields['benevole-activite-admin'] = 1512; // Pour quelles activités - vue admin
	$kino_fields['benevole-charge-admin'] = 1514; // Pour quelles charges - vue admin
	
	
	$kino_fields['id-presentation'] = 31; // is ID complete? champ: Présentation
	$kino_fields['id-photo'] = 859; // champ: Photo
	
	$kino_fields['profil-real-complete'] = 545; // Profil Realisateur complet? champ: présentation
	$kino_fields['profil-comed-complete'] = 927;// Profil Comédien complet? 
	$kino_fields['profil-tech-complete'] = 1075;// Profil Technicien complet? 
	$kino_fields['profil-kabaret-complete'] = 1122;// test = Disponibilités cabaret 
	
	$kino_fields['session-attribuee'] = 1461; // Only visible for Admin 
	
	$kino_fields['rue'] = 9;
	$kino_fields['code-postal'] = 10;
	$kino_fields['ville'] = 11;
	$kino_fields['pays'] = 12;
	$kino_fields['tel'] = 14;
	$kino_fields['birthday'] = 8;
	
	$kino_fields['dispo'] = 1122; // Disponibilités Kino
	$kino_fields['dispo-partiel'] = 1134; // Disponibilités Partielles
	
	$kino_fields['cherche-logement'] = 1143; // oui/non
	$kino_fields['cherche-logement-remarque'] = 1146; // dates et remarques
	$kino_fields['offre-logement'] = 1147; 
	$kino_fields['offre-logement-remarque'] = 1150; // nombre et type de logement
	
	// Compétence Tech
	
	$kino_fields['comp-production'] = 173; // 
	$kino_fields['comp-scenario'] = 385; // 
	$kino_fields['comp-realisation'] = 392; // 
	$kino_fields['comp-image'] = 170; // 
	$kino_fields['comp-postprod-image'] = 413; // 
	$kino_fields['comp-son'] = 400; // 
	$kino_fields['comp-postprod-son'] = 684; // 
	$kino_fields['comp-direction-artistique'] = 405; // 
	$kino_fields['comp-hmc'] = 409; // 
	$kino_fields['comp-autres-liste'] = 418; // 
	$kino_fields['comp-autres-champ'] = 824; //
	$kino_fields['equipement'] = 424; // 
	$kino_fields['equipement-spec'] = 1239; // 
	
	// Compétence Comédien
	
	$kino_fields['age-camera-min'] = 34; // 
	$kino_fields['age-camera-max'] = 35; // 
	$kino_fields['langue-mat'] = 52; // 
	$kino_fields['langue-mat-autre'] = 592; //
	$kino_fields['langues-parlees'] = 58; // 
	$kino_fields['langues-parlees-autre'] = 594; // 
	$kino_fields['langues-jouees'] = 75; // 
	$kino_fields['langues-parlees'] = 593; //
	$kino_fields['poids'] = 36; // 
	$kino_fields['taille'] = 37; // 
	$kino_fields['yeux'] = 38; // 
	$kino_fields['yeux-autre'] = 748; // 
	$kino_fields['cheveux'] = 42; // 
	$kino_fields['cheveux-autre'] = 651; // 
	$kino_fields['talents'] = 82; // 
	$kino_fields['talents-autre'] = 38; // 
	
		
	// Group IDs !
	// ***********
	// voir https://bitbucket.org/ms-studio/kinogeneva/wiki/WordPress-User-Groups
	
	// En attente
	$kino_fields['group-real-kabaret-pending'] = 74 ; // En attente: Réalisateurs Kino Kabaret 2016
	$kino_fields['group-real-platform-pending'] = 77 ; // En attente: Réalisateurs Plateforme
	
	// Validés
	$kino_fields['group-real-kabaret'] = 65 ; // Validés: Réalisateurs Kino Kabaret
	$kino_fields['group-real-platform'] = 66 ; // Validés: Réalisateurs Plateforme
	$kino_fields['group-benevoles-kabaret'] = 67 ; // Bénévoles Kabaret
	
	// Refusés
	$kino_fields['group-real-kabaret-rejected'] = 69 ; // Refusés: Réalisateurs Kino Kabaret 2016
	$kino_fields['group-real-platform-rejected'] = 70 ; // Refusés: Réalisateurs Plateforme
	
	// Profil Kino Kabaret 2016
	$kino_fields['group-kino-incomplete'] = 72 ; // Participants Kino 2016 : profil incomplet
	$kino_fields['group-kino-complete'] = 71 ; // Participants Kino 2016 : profil complet
	$kino_fields['group-kino-approved'] = 73 ; // Participants Kino 2016 : validés
	
	// Logements
	$host = $_SERVER['HTTP_HOST'];
	if ( $host == 'kinogeneva.ch' ) {
	$kino_fields['group-cherche-logement'] = 79 ;  //
	$kino_fields['group-offre-logement'] = 80 ; //
	} else {
	$kino_fields['group-cherche-logement'] = 94 ;  // 79 94
	$kino_fields['group-offre-logement'] = 95 ; // 80 95
	}
	
	// MailPoet List ID:
	// ***********
	$kino_fields['mailpoet-benevoles'] = 6 ;
	$kino_fields['mailpoet-real-platform-only'] = 7 ;
	
	return $kino_fields;
}


