<?php

class sql {
	static public function query ( $sql ) {
		global $SQL;

		$mysql_query = $SQL->prepare( $sql );
		$mysql_query->execute();

		return $mysql_query;
	}

	static public function fields ( $table ) {
		global $SQL;

		$stmt = $SQL->query("SELECT * FROM $table");

		$i = 0;

		$fields = array();
		while ( $column = $stmt->getColumnMeta( $i++ ) ) {
			$fields[] = $column['name'];
		}

		return $fields;
	}

	static public function getInstance () {
		// Connexion à la base de donnée
		if ( config( 'bdd.active' ) ) {
			switch ( config( 'bdd.type' ) ) {
				case 'mysql':
					$dsn = 'mysql:dbname='.config( 'bdd.base' ).';host='.config( 'bdd.host' ).';port='.config( 'bdd.port' );
			
					try {
					    $SQL = new PDO( $dsn, config( 'bdd.user' ), config( 'bdd.mdp' ) );
					}
					catch ( PDOException $e ) {
					    echo 'Connexion échouée : '.$e->getMessage();
						echo '<p>'.$dsn.', '.config( 'bdd.user' ).', '.config( 'bdd.mdp' ).'</p>';
					}
				break;

				case 'mysqli':
					$dsn = 'mysql:dbname='.config( 'bdd.base' ).';host='.config( 'bdd.host' ).';port='.config( 'bdd.port' );
			
					try {
					    $SQL = new PDO( $dsn, config( 'bdd.user' ), config( 'bdd.mdp' ) );
					}
					catch ( PDOException $e ) {
					    echo 'Connexion échouée : '.$e->getMessage();
						echo '<p>'.$dsn.', '.config( 'bdd.user' ).', '.config( 'bdd.mdp' ).'</p>';
					}
				break;
			
				case 'sqlite':
					$dsn = 'sqlite:'.DIR.APP.SQL.config( 'bdd.path' );
		
					try {
					    $SQL = new PDO( $dsn );
					}
					catch ( PDOException $e ) {
					    echo 'Connexion échouée : '.$e->getMessage();
						echo "<p>$dsn</p>";
					}
				break;
			}
		}
		
		return $SQL;
	}
}