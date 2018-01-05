<?php 

function kino_test_fields() {

	// Permet de définir les numéros de champs xprofile à tester 
	// dans un unique endroit!

	$kino_fields = array();
	
	// onglet primaire
	//******************
	$kino_fields['conditions-generales'] = 1070; //accepter les CG
	
	// Onglet: Profil Kinoite : OK 2018
	// **************************
	
	$kino_fields['profile-role'] = 135; // Profil Kinoite Role
	$kino_fields['profile-role-real'] = '2184_2'; // Réalisateur sous Profil Kinoite > Role Plateforme
	$kino_fields['benevole'] = '2185_3'; // Aide Bénévole => sous Profil Kinoite > Role Plateforme
	
	//$kino_fields['kabaret'] = 1832; // Participe au cabaret 2017?
	$kino_fields['kabaret'] = 2060; // Participe au cabaret 2018?
	
	// Onglet: Bénévole
	// **************************
	
	$kino_fields['benevole-kabaret'] = 1320; // Pour quelles activités (fieldset)
	
	$kino_fields['benevole-kabaret-yes'] = '1404_1'; //coche pour le kabaret sous Pour quelles activités (fieldset)
	
	$kino_fields['benevole-fonction'] = 1327; // Pour quelles charges (fieldset)
	
	$kino_fields['benevole-activite-admin'] = 1512; // Pour quelles activités - vue admin
	$kino_fields['benevole-charge-admin'] = 1514; // Pour quelles charges - vue admin
	$kino_fields['benevole-charge-admin-test'] = 1516;
	$kino_fields['fonctions-staff'] = 1582;
	
	
	// Onglet: Identité
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
	
	$kino_fields['profil-real-complete'] = 545; // Profil Realisateur complet? champ: motivation
	$kino_fields['profil-comed-complete'] = 927;// Profil Comédien complet? statut pro/amateur
	$kino_fields['profil-tech-complete'] = 1075;// Profil Technicien complet? statut pro/amateur
	$kino_fields['profil-kabaret-complete'] = 1935;// test = Possibilité hébergement 
	
	// Onglet: Kabaret 2017
	// **************************
	
	// Test des rôles pour le Kabaret 2017
	$kino_fields['role-kabaret'] = 1872; 
	
	// Les trois options des rôles pour le Kabaret :
	$kino_fields['role-kabaret-comed'] = '2170_0';
	$kino_fields['role-kabaret-tech'] = '2171_1';
	$kino_fields['role-kabaret-real'] = '2172_2';
	$kino_fields['role-kabaret-bene'] = '2173_3';
	
	// Les champs Choix de Session pour le Kabaret 2017
	$kino_fields['session-un'] = 1876;
	$kino_fields['session-deux'] = 1881;
	$kino_fields['session-trois'] = 1886;
	//Genève je t'aime 2018
	$kino_fields['session-geneve-je-taime'] = 2162;
	
	$kino_fields['session-attribuee'] = 1891; // Only visible for Admin 
	
	$kino_fields['dispo'] = 1917; // Disponibilités Kino
	$kino_fields['dispo-partiel'] = 1930; // Disponibilités Partielles
	
	$kino_fields['cherche-logement'] = 1931; // oui/non
	$kino_fields['cherche-logement-remarque'] = 1934; // dates et remarques
	
	$kino_fields['offre-logement'] = 1935; 
	$kino_fields['offre-logement-remarque'] = 1936; // nombre et type de logement
	$kino_fields['offre-logement-nb'] = 2103; // nombre de couchage
	
	$kino_fields['possible-tournage'] = 1937;
	$kino_fields['possible-tournage-remarque'] = 1940;
	$kino_fields['possible-tournage-photo'] = 2140;
	
	$kino_fields['vehicule'] = 1941;
	$kino_fields['vehicule-remarque'] = 1944;
	
	$kino_fields['permis'] = 2104;
	
	
	// Compétence Tech
	// **************************
	
	//$kino_fields['profil-tech-complete'] = 1075;// Profil Technicien complet? statut pro/amateur
	$kino_fields['comp-production'] = 173; // 
	$kino_fields['comp-scenario'] = 385; //
	$kino_fields['comp-scenario-scenariste'] = '865_0'; //
	$kino_fields['comp-scenario-soumission'] = 2151; //
	$kino_fields['comp-scenario-file'] = 2154; //
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
	
	////$kino_fields['profil-comed-complete'] = 927;// Profil Comédien complet? statut pro/amateur
	$kino_fields['age-camera-min'] = 34; // 
	$kino_fields['age-camera-max'] = 35; // 
	$kino_fields['langue-mat'] = 52; // 
	$kino_fields['langue-mat-autre'] = 592; //
	//$kino_fields['langues-parlees'] = 58; // 
	//$kino_fields['langues-parlees-autre'] = 594; // 
	$kino_fields['langues-jouees'] = 75; // 
	$kino_fields['langues-jouees-autre'] = 593; //
	$kino_fields['poids'] = 36; // 
	$kino_fields['taille'] = 37; // 
	$kino_fields['yeux'] = 38; // 
	//$kino_fields['yeux-autre'] = 748; // 
	$kino_fields['cheveux'] = 42; // 
	//$kino_fields['cheveux-autre'] = 651; // 
	$kino_fields['talents'] = 82; // 
	$kino_fields['talents-autre'] = 99; // 
	$kino_fields['video-presentation'] = 2018;
	$kino_fields['pole-casting'] = 2200;
	
	// Compétence Réalisateur
	// **************************
	$kino_fields['real-statut'] = 1079;
	//$kino_fields['profil-real-complete'] = 545; // Profil Realisateur complet? champ: motivation
	$kino_fields['real-maj-motiv'] = 2159; // 
	$kino_fields['real-scenar-other'] = 2144;
	$kino_fields['real-coaching'] = 2147; // 
	$kino_fields['real-coaching-scenario'] = 2150; // 
	$kino_fields['real-links'] = 2165; // 
		
// Identifiants des Groupes
// *************************
// voir https://bitbucket.org/ms-studio/kinogeneva/wiki/WordPress-User-Groups
	
// Profil Kino Kabaret
// **********************
	$kino_fields['group-kino-pending'] = 202 ; //participant au kabaret en attente (=> différence avec incomplet?)
	$kino_fields['group-kino-complete'] = 203 ; //participant au kabaret : profil complet
	$kino_fields['group-kino-incomplete'] = 220 ; //participant au kabaret : profil incomplet
	
// Bénévoles Kabaret
// **********************
	$kino_fields['group-benevoles-kabaret'] = 199 ; // 
	
// Logements
// **********************
	$kino_fields['group-cherche-logement'] = 200 ;  //
	$kino_fields['group-offre-logement'] = 201 ; 
	
	
// Réalisateurs
// **********************
	
#real plateforme
	$kino_fields['group-real-platform-pending'] = 197 ; // En attente: Réalisateurs Plateforme
	$kino_fields['group-real-platform'] = 227 ; // Validés: Réalisateurs Plateforme
	$kino_fields['group-real-platform-rejected'] = 229 ; // Refusés: Réalisateurs Plateforme
	$kino_fields['group-real-platform-canceled'] = 234 ; // Annulation: Réalisateurs Plateforme 2017


#real kabaret
	$kino_fields['group-real-kabaret-pending'] = 198 ; // En attente: Réalisateurs Kino Kabaret 2016
	$kino_fields['group-real-kabaret'] = 226 ; // Validés: Réalisateurs Kino Kabaret
	$kino_fields['group-real-kabaret-rejected'] = 228 ; // Refusés: Réalisateurs Kino Kabaret 2017
	$kino_fields['group-real-kabaret-canceled'] = 233 ; // Annulation: Réalisateurs Kino Kabaret 2017

	
	//real vus
	$kino_fields['group-candidats-vus-moyens'] = 231 ; //
	$kino_fields['group-candidats-vus-biens'] = 232 ; //

	// Groupes Sessions
	$kino_fields['group-session-un'] = 235 ;
	$kino_fields['group-session-deux'] = 236 ;
	$kino_fields['group-session-trois'] = 237 ;
	$kino_fields['group-session-superhuit'] = 238 ;
	
	//Participants Kino 2017 : Validés : groupe à effacer, ancien groupe pour les réal validés
	$kino_fields['group-kino-approved'] = 230 ;
	

// MailPoet List IDs (valeurs 2017)
// **********************
	
	//participants
	$kino_fields['mailpoet-participant-kabaret'] = 7 ; //Kino Kabaret (Profil Complet)
	$kino_fields['mailpoet-participant-kabaret-incomplet'] = 5 ;
	
	//bénévoles
	$kino_fields['mailpoet-benevoles'] = 3;
	
	//réalisateurs kabaret
	$kino_fields['mailpoet-real-kabaret-pending'] = 8 ; // Réal Kabaret (En Attente)
	$kino_fields['mailpoet-real-kabaret'] = 4 ; // Validés: Réalisateurs Kino Kabaret
	$kino_fields['mailpoet-real-kabaret-rejected'] = 10 ; //Refusés: Réalisateurs Kino Kabaret 2017
	
	// Sessions
	$kino_fields['mailpoet-session-un'] = 13 ;
	$kino_fields['mailpoet-session-1'] = 13 ;
	$kino_fields['mailpoet-session-deux'] = 14 ;
	$kino_fields['mailpoet-session-2'] = 14 ;
	$kino_fields['mailpoet-session-trois'] = 15 ;
	$kino_fields['mailpoet-session-3'] = 15 ;
	$kino_fields['mailpoet-session-superhuit'] = 16 ;


	//réalisateurs plateforme
	$kino_fields['mailpoet-real-platform'] = 9 ; // Acceptés: Réalisateurs Plateforme
	$kino_fields['mailpoet-real-platform-rejected'] = 11 ; //Refusés: Réalisateurs Plateforme
	
	//"Réal plateforme" id 18 ? a supprimer dans le backend ?

	//$kino_fields['mailpoet-real-platform-only'] = 17 ;


	// Groupes Compétences
	$kino_fields['group-comp-comedien'] = 278 ;
	$kino_fields['group-comp-technicien'] = 279 ;
	$kino_fields['group-comp-image'] = 280 ;
	$kino_fields['group-comp-postprod-image'] = 281 ;
	$kino_fields['group-comp-postprod-son'] = 282 ;
	$kino_fields['group-comp-prod-scenar'] = 283 ;
	$kino_fields['group-comp-da-hmc'] = 284 ;
	$kino_fields['group-comp-autres'] = 285 ;
	$kino_fields['group-comp-staff'] = 286 ;
	
	// Groupes Compta
	
	$kino_fields['compta-paid-25'] = 287 ; //
	$kino_fields['compta-paid-offert-25'] = 434; // offert 25.-
	$kino_fields['compta-paid-40'] = 431 ; // membre de soutien
	$kino_fields['compta-paid-100'] = 288 ; //
	$kino_fields['compta-paid-125'] = 429; // inscription - 125.-
	$kino_fields['compta-paid-offert-125'] = 435; //offert:inscription 125.-
	
	$kino_fields['compta-repas-60'] = 289 ; //
	$kino_fields['compta-repas-offert-60'] = 432; //offert 60.- repas
	$kino_fields['compta-repas-100'] = 290 ; //
	$kino_fields['compta-repas-125'] = 430; //repas 125.-
	$kino_fields['compta-repas-offert-125'] = 433; //offert 125.- repas
	
	return $kino_fields;
}


