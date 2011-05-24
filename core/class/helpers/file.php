<?php

class file {
	static public function add ( $file, $content = '', $params = array() ) {
		self::mkdir( $file );

		return file_put_contents( $file, $content );
	}

	static public function view ( $file, $params = array() ) {
		return file_get_contents( $file );
	}

	static public function get ( $file, $params = array() ) {
		return self::view( $file, $params );
	}

	static public function put ( $file, $content = '', $params = array() ) {
		return self::add( $file, $content, $params );
	}

	static public function fill ( $src, $dest, $params = array() ) {
		// dir
		if ( is_dir( $src ) ) {
			// on liste tous les fichiers de facon recursif
			$files = self::find( $src.'*.*' );
			
			foreach ( $files as $i => $item ) {
				self::fill( $item, $dest, $params );
			}
		}
		// file
		else {
			exit( '<b>'.__DIR__.' ( '.__LINE__.' ):</b><br />le premier argument est un fichier la function nest pas encore d�fini pour ce cas, seulement pour un repertoire !<br />le probleme a r�soudre et quil faudrai savoir quel est le r�pertoire root du fichier pour pouvoir le copier au bon endroit' );

			// on remplace les occurences de params dans le nom du fichier
			// on remplace les occurences de params dans le contenu fu fichier
			 $str = str_replace( array_keys( $params ), array_values( $params ), self::get( DIR.APP.MODULE.'-'.DS.$src ) );
		}
		
		
		
		return self::put( $dest, $str );
	}

	static public function find ( $expresion, $recurcif = true, $params = array() ) {
		return glob( $expresion );
	}

	static public function mkdir ( $file, $params = array() ) {
		$dir = dirname( $file );
		$name = basename( $file );

		// cr�ation des r�pertoires
		$dirs = explode( '/', trim( $dir, '/' ) );

		if ( count( $dirs ) > 0 ) {
			$before_dir = '/';

			foreach ( $dirs as $_dir ) {
				$new_dir = $before_dir.$_dir.'/';

				if ( !is_dir( $new_dir ) ) {
					mkdir( $new_dir, 755 );
				}

				$before_dir = $new_dir;
			}
		}
	}
}