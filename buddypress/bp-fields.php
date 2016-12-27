<?php 

function kino_test_fields() {

	// Permet de définir les numéros de champs xprofile à tester 
	// dans un unique endroit!

	$kino_fields = array();
	
	
	// Groupe: Profil Kinoite
	// **************************
	
	$kino_fields['profile-role'] = 135; // Profil Kinoite Role
	$kino_fields['profile-role-real'] = '1424_2'; // Profil Kinoite Role Plateforme
	
	$kino_fields['conditions-generales'] = 1070; // Profil Kinoite Role
	
	$kino_fields['kabaret'] = 1832; // Participe au cabaret 2017?
	
		
	// Groupe: Bénévole
	// **************************
	
	$kino_fields['benevole'] = 1313; // Aide Bénévole (sur Profil Kinoite)
	
	$kino_fields['benevole-kabaret'] = 1320; // Pour quelles activités (fieldset)
	
	$kino_fields['benevole-fonction'] = 1327; // Pour quelles charges (fieldset)
	
	$kino_fields['benevole-activite-admin'] = 1512; // Pour quelles activités - vue admin
	$kino_fields['benevole-charge-admin'] = 1514; // Pour quelles charges - vue admin
	$kino_fields['benevole-charge-admin-test'] = 1516;
	$kino_fields['fonctions-staff'] = 1582;
	
	
	// Groupe: Identité
	// **************************
	
	$kino_fields['courriel'] = 1831;
	// Sous Identité
	
	$kino_fields['rue'] = 9;
	$kino_fields['code-postal'] = 10;
	$kino_fields['ville'] = 11;
	$kino_fields['pays'] = 12;
	$kino_fields['tel'] = 14;
	$kino_fields['birthday'] = 8;
	
	$kino_fields['id-presentation'] = 31; // is ID complete? champ: Présentation
	$kino_fields['id-photo'] = 859; // champ: Photo
	$kino_fields['id-cv'] = 858; // champ: CV
	
	
	
	
	// Test des champs complets:
	// **************************
	
	// On teste arbitrairement un des champs obligatoires du profil, afin de déterminer si le profil a été rempli.
	
	$kino_fields['profil-real-complete'] = 545; // Profil Realisateur complet? champ: présentation
	$kino_fields['profil-comed-complete'] = 927;// Profil Comédien complet? 
	$kino_fields['profil-tech-complete'] = 1075;// Profil Technicien complet? 
	$kino_fields['profil-kabaret-complete'] = 1935;// test = Possibilité hébergement 
	
	
	
	// Groupe: Kabaret 2017
	// **************************
	
	// Test des rôles pour le Kabaret 2017
	$kino_fields['role-kabaret'] = 1872; 
	
	// Les trois options des rôles pour le Kabaret 2017:
	$kino_fields['role-kabaret-comed'] = '1873_0';
	$kino_fields['role-kabaret-tech'] = '1874_1';
	$kino_fields['role-kabaret-real'] = '1875_2';
	
	// Les champs Choix de Session pour le Kabaret 2017
	$kino_fields['session-un'] = 1876;
	$kino_fields['session-deux'] = 1881;
	$kino_fields['session-trois'] = 1886;
	
	$kino_fields['session-attribuee'] = 1891; // Only visible for Admin 
	
	$kino_fields['dispo'] = 1917; // Disponibilités Kino
	$kino_fields['dispo-partiel'] = 1930; // Disponibilités Partielles
	
	$kino_fields['cherche-logement'] = 1931; // oui/non
	$kino_fields['cherche-logement-remarque'] = 1934; // dates et remarques
	
	$kino_fields['offre-logement'] = 1935; 
	$kino_fields['offre-logement-remarque'] = 1936; // nombre et type de logement
	
	$kino_fields['possible-tournage'] = 1937;
	$kino_fields['possible-tournage-remarque'] = 1940;
	
	$kino_fields['vehicule'] = 1941;
	$kino_fields['vehicule-remarque'] = 1944;
	
	
	// Compétence Tech
	// **************************
	
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
	// **************************
	
	$kino_fields['age-camera-min'] = 34; // 
	$kino_fields['age-camera-max'] = 35; // 
	$kino_fields['langue-mat'] = 52; // 
	$kino_fields['langue-mat-autre'] = 592; //
	$kino_fields['langues-parlees'] = 58; // 
	$kino_fields['langues-parlees-autre'] = 594; // 
	$kino_fields['langues-jouees'] = 75; // 
	$kino_fields['langues-jouees-autre'] = 593; //
	$kino_fields['poids'] = 36; // 
	$kino_fields['taille'] = 37; // 
	$kino_fields['yeux'] = 38; // 
	$kino_fields['yeux-autre'] = 748; // 
	$kino_fields['cheveux'] = 42; // 
	$kino_fields['cheveux-autre'] = 651; // 
	$kino_fields['talents'] = 82; // 
	$kino_fields['talents-autre'] = 99; // 
	
		
		
		
	// Identifiants des Groupes
	// *************************
	
	// voir https://bitbucket.org/ms-studio/kinogeneva/wiki/WordPress-User-Groups
	
	// Groupes Sélection
	
	// En attente
	
	$kino_fields['group-real-platform-pending'] = 197 ; // En attente: Réalisateurs Plateforme
	
	$kino_fields['group-real-kabaret-pending'] = 198 ; // En attente: Réalisateurs Kino Kabaret 2016
	
	// Profil Kino Kabaret
	// **********************
	
	$kino_fields['group-kino-pending'] = 202 ;
	
	$kino_fields['group-kino-complete'] = 203 ; // Participants Kabaret : profil complet
	
	
	// Bénévoles Kabaret
	// **********************
	
	$kino_fields['group-benevoles-kabaret'] = 199 ; // 

	
	// Logements
	// **********************
	
	$kino_fields['group-cherche-logement'] = 200 ;  //
	$kino_fields['group-offre-logement'] = 201 ; 
	
	
	$kino_fields['group-kino-incomplete'] = 220 ; // Participants Kino 2016 : profil incomplet
	
	//mis à jour 2017
	// Validés
	$kino_fields['group-real-kabaret'] = 226 ; // Validés: Réalisateurs Kino Kabaret
	$kino_fields['group-real-platform'] = 227 ; // Validés: Réalisateurs Plateforme
	
	// Groupes Sessions
	$kino_fields['group-session-un'] = 235 ;
	$kino_fields['group-session-deux'] = 236 ;
	$kino_fields['group-session-trois'] = 237 ;
	$kino_fields['group-session-superhuit'] = 238 ;
	
	
	// Refusés
	$kino_fields['group-real-kabaret-rejected'] = 228 ; // Refusés: Réalisateurs Kino Kabaret 2017
	$kino_fields['group-real-platform-rejected'] = 229 ; // Refusés: Réalisateurs Plateforme

	$kino_fields['group-kino-incomplete'] = 203 ; // Participants Kino 2017 : profil incomplet
	$kino_fields['group-kino-approved'] = 230 ; // Participants Kino 2017 : validés

	$kino_fields['group-candidats-vus-moyens'] = 231 ; //
	$kino_fields['group-candidats-vus-biens'] = 232 ; //

	//annulation
	$kino_fields['group-real-kabaret-canceled'] = 233 ; // Annulation: Réalisateurs Kino Kabaret 2017
	$kino_fields['group-real-platform-canceled'] = 234 ; // Annulation: Réalisateurs Plateforme 2017
	
	//Participants Kino 2017 : Validés
	$kino_fields['group-kino-approved'] = 230 ;

	// MailPoet List IDs (valeurs 2017)
	// **********************
	
	$kino_fields['mailpoet-benevoles'] = 3;
	
	// réalisateurs
	$kino_fields['mailpoet-real-kabaret-pending'] = 8 ; // Réal Kabaret (En Attente)

	$kino_fields['mailpoet-real-kabaret'] = 4 ; // Validés: Réalisateurs Kino Kabaret 2017
	$kino_fields['mailpoet-real-platform'] = 9 ; // Acceptés

	$kino_fields['mailpoet-real-platform-only'] = 17 ;

	$kino_fields['mailpoet-real-kabaret-rejected'] = 10 ; //Refusés: Réalisateurs Kino Kabaret 2017
	$kino_fields['mailpoet-real-platform-rejected'] = 11 ; //Refusés: Réalisateurs Plateforme

	// Sessions
	$kino_fields['mailpoet-session-un'] = 13 ;
	$kino_fields['mailpoet-session-deux'] = 14 ;
	$kino_fields['mailpoet-session-trois'] = 15 ;
	$kino_fields['mailpoet-session-superhuit'] = 16 ;

	//participants
	$kino_fields['mailpoet-participant-kabaret'] = 7 ; //Kino Kabaret (Profil Complet)
	$kino_fields['mailpoet-participant-kabaret-incomplet'] = 5 ;
	
	// Groupes Compétences
	
	$kino_fields['group-comp-comedien'] = 278 ; //
	$kino_fields['group-comp-technicien'] = 279 ; //
	$kino_fields['group-comp-image'] = 280 ; //
	$kino_fields['group-comp-postprod-image'] = 281 ; //
	$kino_fields['group-comp-postprod-son'] = 282 ; //
	$kino_fields['group-comp-prod-scenar'] = 283 ; //
	$kino_fields['group-comp-da-hmc'] = 284 ; //
	$kino_fields['group-comp-autres'] = 285 ; //
	$kino_fields['group-comp-staff'] = 286 ; //
	
	// Groupes Compta
	
	$kino_fields['compta-paid-25'] = 287 ; //
	$kino_fields['compta-paid-100'] = 288 ; //
	$kino_fields['compta-repas-60'] = 289 ; //
	$kino_fields['compta-repas-100'] = 290 ; //
	
	return $kino_fields;
}


