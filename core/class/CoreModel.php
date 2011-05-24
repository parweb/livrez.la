<?php

class CoreModel {
	public $name;
	public $alias;

	public $primary = array(
		'id' => array(
			'type' => 'primary',
			'validate' => array(
				'required' => true,
				'max' => 11
			)
		)
	);
	
	protected $_data = array();

	public $belong = array();
	public $many = array();
	public $one = array();

	public $display = 'title';
	public $fields = array();

	private $out;
	private $appli;

	public function __construct () {
		$this->setname();
		$this->alias = $this->name();

		$this->fields = array_merge( $this->primary, $this->fields );

		if ( !$this->table_existe() ) {
			$this->create_table();
		}
	}

	public function __set ( $key, $val ) {
		$this->_data[$key] = $val;

		return $this;
	}

	public function __get ( $key ) {
		return $this->_data[$key];
	}

	private function name () {
		return strtolower( $this->name );
	}

	private function setname ( $name = '' ) {
		$this->name = ( $name  == '' ) ? strtolower( str_replace( 'Model', '', get_class( $this ) ) ) : $name;
	}

	private function alias () {
		return strtolower( $this->alias );
	}

	private function primary () {
		$primary = array_keys( $this->primary );

		return $primary[0];
	}

	public function belong () {
		return $this->belong;
	}

	public function many () {
		return $this->many;
	}

	public function one () {
		return $this->one;
	}

	public function display () {
		return $this->display;
	}

	private function constructFrom () {
		$i = 0;

		$class = strtolower( $this->name() );

		$thisVal = $this->name();
		$thisAlias = $this->alias();
		$thisKey = $this->name();

		$defaut_alias = ( isset( $thisAlias ) ? $thisAlias : $class[0] );
		$defaut_val = ( isset( $thisVal ) ? $thisVal : $class );

		$out[$i]['alias'] = $defaut_alias;
		$out[$i]['table'] = $defaut_val;

		$i++;

		if ( is_array( $this->appli['from'] ) ) {
			$froms = array_unique( $this->appli['from'] );

			foreach ( $froms as $from ) {
				list( $table, $alias ) = explode( ' ', $from );

				$out[$i]['alias'] = $alias;
				$out[$i]['table'] = $table;

				$i++;
			}
		}
		elseif ( is_string( $this->appli['from'] ) ) {
			if ( !empty( $this->appli['from'] ) ) {
				list( $table, $alias ) = explode( ' ', $this->appli['from'] );

				$out[$i]['alias'] = $alias;
				$out[$i]['table'] = $table;
			}
		}

		return $out;
	}

	private function getSelect () {
		$froms = $this->constructFrom();

		if ( count( $froms ) ) {
			$out = '';
			foreach ( $froms as $from ) {
				$out .= $from['alias'].'.*, ';
			}
		}

		if ( is_array( $this->appli['select'] ) ) {
			$selects = array_unique( $this->appli['select'] );

			$out = '';
			foreach ( $selects as $select ) {
				$out .= $select.", ";
			}
		}
		elseif ( is_string( $this->appli['select'] ) ) {
			if ( !empty( $this->appli['select'] ) ) {
				$out = $this->appli['select'].", ";
			}
		}

		$out = 'SELECT '.trim( $out, ', ' );

		return $out;
	}

	private function getFrom () {
		$froms = $this->constructFrom();
		if ( count( $froms ) ) {
			$out = ' FROM ';

			foreach ( $froms as $from ) {
				$out .= $from['table'].' AS '.$from['alias'].", ";
			}
		}

		$out = trim( $out, ', ' );

		return ' '.$out;
	}

	private function getJoin () {
		foreach ( $this->many() as $many ) {
			$query .= "";
		}
	}

	private function getWhere () {
		if ( is_array( $this->appli['where'] ) ) {
			$this->appli['where'] = array_unique( $this->appli['where'] );

			$out = '';
			foreach ( $this->appli['where'] as $where ) {
				if ( !empty( $where ) ) {
					$out .= $where.' AND ';
				}
			}
		}
		elseif ( is_string( $this->appli['where'] ) ) {
			if ( !empty( $this->appli['where'] ) ) {
				$out = $this->appli['where'];
			}
		}

		if ( !empty( $out ) ) {
			$out = ' WHERE '.trim( $out, ' AND ' );
		}

		if ( $out == ' WHERE ' ) {
			$out = '';
		}

		return $out.$this->getJoin();
	}

	private function getOrderby () {
		return ( !empty( $this->appli['orderby'] ) ? ' ORDER BY '.$this->appli['orderby'] : '' );
	}

	private function getLimit () {
		return ( !empty( $this->appli['limit'] ) ? ' LIMIT '.$this->appli['limit'] : '' );
	}

	private function getGroupby () {
		if ( is_array( $this->appli['groupby'] ) ) {
			$this->appli['groupby'] = array_unique( $this->appli['groupby'] );

			$out = ' GROUP BY ';
			foreach ( $this->appli['groupby'] as $groupby ){
				$out .= $groupby.', ';
			}

			$out = ' '.trim( $out, ', ' );
		}
		elseif ( is_string( $this->appli['groupby'] ) ) {
			if ( !empty( $this->appli['groupby'] ) ) {
				$out = ' GROUP BY '.$this->appli['groupby'];
			}
		}

		return $out;
	}

	private function getHaving () {
		if ( is_array( $this->appli['having'] ) ) {
			$this->appli['having'] = array_unique( $this->appli['having'] );

			$out = ' HAVING ';
			foreach ( $this->appli['having'] as $having ){
				$out .= $having.', ';
			}

			$out = ' '.trim( $out, ', ' );
		}
		elseif ( is_string( $this->appli['having'] ) ) {
			if ( !empty( $this->appli['having'] ) ) {
				$out = ' HAVING '.$this->appli['having'];
			}
		}

		return $out;
	}

	public function getQuery ( $appli ) {
		$this->appli = $appli;

		if ( $appli['debug'] ) {
			unset( $appli['debug'] );
			echo $this->getQuery( $appli );exit;
		}

		return $this->getSelect().$this->getFrom().$this->getWhere().$this->getGroupby().$this->getHaving().$this->getOrderby().$this->getLimit();
	}

	public function add ( $array ) {
		global $SQL;

		if ( $this->hasDate() ) {
			$array['date'] = 'NOW()';
		}

		if ( count( $array ) > 0 ) {
			$head = '`'.join( '`, `', array_keys( $array ) ).'`';
			$values = "'".join( "', '", array_values( $array ) )."'";

			$values = str_replace( "'NOW()'", 'NOW()', $values );
		}

		$mysql_query = $SQL->prepare( "INSERT INTO ".$this->name()." ( $head ) VALUES( $values )" );

		if ( !is_object( $mysql_query ) ) {
			echo "INSERT INTO ".$this->name()." ( $head ) VALUES( $values )".'<br />';
		}
		else {
			$mysql_query->execute();
		}

		$id = $SQL->lastInsertId();

		return $id;
	}

	public function delete ( $id ) {
		global $SQL;

		$mysql_query = $SQL->prepare( "DELETE FROM ".$this->name()." WHERE ".$this->name()." = '".(int)$id."'" );
		$mysql_query->execute();
	}

	public function delete_where ( $params ) {
		global $SQL;

		if ( is_array( $params ) ) {
			$params = array_unique( $params );

			$out_where = '';
			foreach ( $params as $where ) {
				if ( !empty( $where ) ) {
					$out_where .= $where.' AND ';
				}
			}
		}
		elseif ( is_string( $params ) ) {
			if ( !empty( $params ) ) {
				$out_where = $params;
			}
		}

		if ( !empty( $out_where ) ) {
			$out_where = trim( $out_where, ' AND ' );

			$out_where = ' WHERE '.$out_where;
		}

		if ( $out_where == ' WHERE ' ) {
			$out_where = '';
		}

		$mysql_query = $SQL->prepare( "DELETE FROM ".$this->name()." ".$out_where );
		$mysql_query->execute();
	}

	private function hasDate () {
		foreach ( $this as $field => $value ) {
			if ( $field == 'date' ) {
				return true;
			}
		}
	}

	public function save ( $id, $array ) {
		global $SQL;

		if ( $this->hasDate() ) {
			$array['date'] = 'NOW()';
		}

		if ( count( $array ) > 0 ) {
			$update = 'SET ';

			foreach ($array as $k => $v ) {
				if ( $v == '++' ) {
					$update .= '`'.$k.'` = '.$k.' + 1'.', ';
				}
				elseif ( $v == '--' ) {
					$update .= '`'.$k.'` = '.$k.' - 1'.', ';
				}
				elseif ( $k == 'date' ) {
					$update .= '`'.$k.'` = '.$v.', ';
				}
				else {
					$update .= '`'.$k.'` = \''.$v.'\', ';
				}
			}

			$update = trim( $update, ', ' );
		}

		$sql = "UPDATE `".$this->name()."` ".$update." WHERE ".$this->name()." = '$id'";

		$mysql_query = $SQL->prepare( $sql );
		$mysql_query->execute();

		$id = $SQL->lastInsertId();

		return $id;
	}

	public function verif_exist ( $where ) {
		$appli['where'] = $where;
		$appli['limit'] = 1;

		$listes = $this->listes( $appli );

		if ( count( $listes ) > 0 ) {
			$return = $listes[0][$this->name()];
		}
		else {
			$return = false;
		}

		return $return;
	}

	public function getPublic () {
		$req = mysql_query( "SHOW FIELDS FROM ".$this->name() );
		while ( $rep = mysql_fetch_assoc( $req ) ) {
			echo 'public $'.$rep['Field'].';<br />';
		}

		exit;
	}

	public function table_existe () {
		$sql = 'SHOW TABLES';

		$mysql_query = sql::query( $sql );

		$tables = $mysql_query->fetchAll();

		$return = false;
		foreach ( $tables as $table ) {
			if ( $table[0] == $this->name() ) {
				$return = true;
			}
		}

		return $return;
	}

	public function create_table ( $params = array() ) {
		$sql = 'CREATE TABLE `'.$this->name().'` ('."\n";
			foreach ( $this->fields as $name => $item ) {
				switch ( $item['type'] ) {
					case 'primary':
						$max = ( isset( $item['validate']['max'] ) ) ? $item['validate']['max'] : 11;
						$sql .= "\t".'`'.$name.'` int('.$max.') NOT NULL AUTO_INCREMENT,'."\n";
					break;

					case 'numeric':
						$max = ( isset( $item['validate']['max'] ) ) ? $item['validate']['max'] : 11;
						$sql .= "\t".'`'.$name.'` INT('.$max.') NOT NULL,'."\n";
					break;

					case 'text':
						$max = ( isset( $item['validate']['max'] ) ) ? $item['validate']['max'] : 255;
						$sql .= "\t".'`'.$name.'` varchar('.$max.') NOT NULL,'."\n";
					break;

					case 'textarea':
						$sql .= "\t".'`'.$name.'` text NOT NULL,'."\n";
					break;

					case 'date':
						$sql .= "\t".'`'.$name.'` DATETIME NOT NULL,'."\n";
					break;
				}
			}

			$sql .= "\t".'PRIMARY KEY (`'.$this->primary().'`)'."\n";
		$sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
debug($sql);
		sql::query( $sql );
	}

	public function listes ( $appli = array(), $sortie = 'recursif', $field = '' ) {
		global $SQL, $bdd;

		if ( $bdd['active'] ) {
			$this->out = $sortie;

			if ( $this->out == 'first' || $this->out == 'extract' ) {
				$appli['limit'] = 1;
			}

			if ( $this->out == 'count' ) {
				$appli['select'] = $this->name();
			}

			$sql = $this->getQuery( $appli );

			$mysql_query = $SQL->prepare( $sql );

			if ( !is_object( $mysql_query ) ) {
				echo 'file: '.__FILE__.' ligne: '.__LINE__."<br /><b>\$sql ($sortie):</b> ".$sql.'<br />';
			}
			else {
				$mysql_query->execute();
			}

			if ( $this->out == 'count' ) {
				return count( $mysql_query->fetchAll() );
			}
			elseif ( $this->out == 'pipe' ) {
				if ( mysql_num_rows( $mysql_query ) > 0 ) {
					while ( $lists = mysql_fetch_assoc( $mysql_query ) ) {
						$lists_array[] = $lists[$field];
					}

					return array2pipe( $lists_array );
				}
			}
			elseif ( $this->out == 'extract' ) {
				$liste = $mysql_query->fetchAll( PDO::FETCH_ASSOC );

				return $liste[0][$field];
			}
			elseif ( $this->out == 'first' ) {
				$liste = $mysql_query->fetchAll( PDO::FETCH_ASSOC );

				return $liste[0];
			}
			elseif ( $this->out == 'array' && $field != '' ) {
				if ( mysql_num_rows( $mysql_query ) > 0 ) {
					while ( $lists = mysql_fetch_assoc( $mysql_query ) ) {
						$lists_array[] = $lists[$field];
					}

					if ( !count( $lists_array ) ) {
						return array();
					}

					return $lists_array;
				}
			}
			else {
				$tuples = $mysql_query->fetchAll( PDO::FETCH_CLASS, ucfirst( $this->name().'Model' ) );

				if ( !count( $tuples ) ) {
					$tuples = array();
				}

				if ( $this->out == 'recursif' ) {
					foreach ( $tuples as $i => $tuple ) {
						foreach ( $this->belong() as $item ) {
							$class_name = ucfirst( $item );
							$Class = new $class_name;

							$item_key = $Class->name();

							unset( $tuples[$i]["{$item}_{$item_key}"] );
							$tuples[$i][$item] = $Class->listes( array( 'where' => array( "{$item}.{$item_key} = '".$tuple["{$item}_{$item_key}"]."'" ) ), 'first' );
						}

						foreach ( $this->many() as $item ) {
							$class_name = ucfirst( $item );
							$Class = new $class_name;

							$current_key = $this->name();

							$current_class_name = $this->name();

							$tuples[$i][$item] = $Class->listes( array( 'where' => array( "{$item}.{$current_class_name}_{$current_key} = $tuple[$current_key]" ) ) );
						}
					}
				}

				return $tuples;
			}
		}
		else {
			return array();
		}

	}
}