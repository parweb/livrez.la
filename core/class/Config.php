<?php

require_once 'Singleton.php';

class Config extends Singleton {
	public static $configs = array();

	static public function init () {
		// dossier du cms
		define( 'DIR_SITE', dirname( $_SERVER['SCRIPT_FILENAME'] ).DS );

		// url de base
		define( 'URL_SITE', str_replace( rtrim( $_SERVER['DOCUMENT_ROOT'], DS ), '', DIR_SITE ) );

		// dossier principaux de beer
		define( 'DIR', DIR_SITE );
		define( 'URL', URL_SITE );
			define( 'APP', 'app'.DS );
				define( 'SQL', 'sql'.DS );
				define( 'CONFIG', 'config'.DS );
				define( 'TMP', 'tmp'.DS );
				define( 'TEMPLATE', 'template'.DS );
					define( 'CSS', 'css'.DS );
					define( 'JS', 'css'.DS );
				define( 'MODULE', 'module'.DS );
					define( 'MODULE_CLASS', MODULE.'class'.DS );
			define( 'CORE', 'core'.DS );
				define( 'CORE_CLASS', CORE.'class'.DS );
				define( 'FIREWALL', 'php-firewall'.DS );

		// firewall php
		require_once DIR.CORE.FIREWALL.'firewall.php';
		define( 'URL_REQUEST', PHP_FIREWALL_REQUEST_URI );
	}

	static public function loadFiles () {
		if ( $files = glob ( DIR.APP.CONFIG.'*.php' ) ) {
			array_map ( 'config::load', $files );
		}
	}

	static public function load ( $file ) {
		// Get filename
		if ( file_exists ( $file ) ) {
			$filename = $file;
		}
		else {
			$filename = DIR.APP.CONFIG."$file.php";
			
			if (! file_exists ( $filename ) ) {
				throw new Exception ( "Config file '$file' not found" );
			}
		}

		$config = include_once $filename;
		
		foreach ( $config as $section => $value ) {
			self::$configs[$section] = $value;
		}
	}
}