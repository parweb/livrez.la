<?php

class js extends asset {
	static public function add () {
		self::$assets['js'] = (array)func_get_args();
	}

	public static function minify ( $new_file = 'minify' ) {
		return parent::minify( 'js', $new_file );
	}
}