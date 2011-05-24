<?php

class date {
	public static function now () {
		return date( 'Y-m-d H:i:s' );
	}

	public static function datepicker2datesql ( $date, $end = '00:00:00' ) {
		list( $day, $month, $year ) = explode( '/', $date );
		return date( 'd/m/Y '.$end, strtotime( "$year-$month-$day $end" ) );
	}

	public static function datesql2datepicker ( $date ) {
		if ( $date == '1970-01-01' ) {
			return 'Inconnu';
		}
		else {
			return self::convert( 'd/m/Y', $date );
		}
	}

	public static function convert ( $shema, $date ) {
		$english = array( 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
		$french = array( 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'decembre' );

		return str_replace( $english, $french, date( $shema, strtotime( $date ) ) );
	}
}
