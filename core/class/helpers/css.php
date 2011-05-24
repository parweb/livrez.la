<?php

class css extends asset {
	static public function add () {
		self::$assets['css'] = (array)func_get_args();
	}

	public static function minify ( $new_file = 'minify' ) {
		return parent::minify( 'css', $new_file );
	}
}