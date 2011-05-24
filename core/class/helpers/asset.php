<?php

class asset extends Singleton {
	public static $assets = array();
	public static $type;

	public static function minify ( $type, $new_file = 'minify' ) {
		$path_asset = APP.TEMPLATE.config('view.template').DS.$type.DS;

		$return = '';
		foreach ( self::$assets[$type] as $item ) {
			$string = file::get( DIR.$path_asset.$item.'.'.$type );

			// Strips Comments
			$string = preg_replace('!/\*.*?\*/!s','', $string);
			$string = preg_replace('/\n\s*\n/',"\n", $string);
			
			// Minifies
			$string = preg_replace('/[\n\r \t]/',' ', $string);
			$string = preg_replace('/ +/',' ', $string);
			
			// return
			$return .= preg_replace('/ ?([,:;{}]) ?/','$1',$string);
		}

		file::put( DIR.$path_asset.$new_file.'.'.$type, $return );

		return URL."$path_asset$new_file.$type";
	}
}