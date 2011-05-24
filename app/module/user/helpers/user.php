<?php

class user {
	static public function needLogin () {
		if ( !self::is_login() && AUTH ) {
			url::redirect( link::href( 'user', 'login' ) );
		}
	}

	static public function is_login () {
		global $_SESSION, $User;

		$return = false;
		if ( $_SESSION['user']['session'] == $User->sessioncode ) {
			$return = $User->id;
		}

		return $return;
	}

	static public function needAdmin () {
		if ( !self::is_admin() && AUTH ) {
			url::redirect( link::href( 'user', 'login' ) );
		}
	}

	static public function is_admin () {
		$User = new User( self::sessioncode2userid() );

		$return = false;
		if ( $User->status == 5 ) {
			$return = true;
		}

		return $return;
	}

	static public function needSecretaire () {
		if ( !self::is_secretaire() ) {
			url::redirect( link::href( 'user', 'login' ) );
		}
	}

	static public function is_secretaire () {
		$User = new User( self::sessioncode2userid() );

		$return = false;
		if ( $User->status == 4 ) {
			$return = true;
		}

		return $return;
	}

	static public function need ( $array = array() ) {
		$User = new User( self::sessioncode2userid() );

		$alias = array(
			4 => 'secretaire',
			5 => 'admin'
		);

		if ( !in_array( $alias[$User->status], $array ) && AUTH ) {
			url::redirect( link::href( 'user', 'login' ) );
		}
	}

	static public function sessioncode2userid ( $sessioncode = '' ) {
		if ( $sessioncode == '' ) {
			global $_SESSION;

			$sessioncode = $_SESSION['user']['session'];
		}

		$appli['select'][] = "user.id";
		$appli['where'][] = "user.sessioncode = '$sessioncode'";

		$User = new User();

		return $User->listes( $appli, 'extract', 'id' );
	}

	static private function userurl2usergroup ( $user_url = '' ) {
		if ( $user_url == '' ) {
			$user_url = self::is_login();
		}

		$appli['select'][] = "ug.group_url";
		$appli['where'][] = "u.user_url = '$user_url'";

		return self::listes( $appli, 'extract', 'group_url' );
	}

	static public function listes ( $appli = array(), $sortie = '', $field = '' ) {
		$appli['form'][] = "usergroup ug";
		$appli['where'][] = "ug.usergroup_id = u.usergroup_id";

		return parent::listes( $appli, $sortie, $field );
	}
	
	static public function getAdmin ( $field ) {
		global $User;
		
		$out = ( !empty( $field ) ) ? 'extract' : 'first';
		
		return $User->listes( array( 'where' => 'user.status = 5' ), $out, $field );
	}
	
	private function create_admin () {
		
	}
}