<?php 

// 

function kino_process_niveau( $kino_niveau ) {
		
		$kino_niveau_output = '';
		
		if ( $kino_niveau == 'Professionnel-le') {
			$kino_niveau_output = 'pro';
		}
		
		if ( $kino_niveau == 'Professionnel-le en devenir') {
			$kino_niveau_output = 'en devenir';
		}
		
		if ( $kino_niveau == 'Amateur-e passionné-e') {
			$kino_niveau_output = 'amateur';
		}
		
		return $kino_niveau_output;
		
}

