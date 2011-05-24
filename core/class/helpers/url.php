<?php

class url {
	public static function url2params () {
		$params = explode( DS, trim( str_replace( URL, '', URL_REQUEST ), DS ) );

		if ( count( $params ) > 0 ) {
			$array = array();

			foreach ( $params as $i => $param ) {
				if ( !empty( $param ) ) {
					if ( $i == 0 && !preg_match( '|:|', $param ) ) {
						$array['module'] = $param;
					}
					elseif ( $i == 1 && !preg_match( '|:|', $param ) ) {
						$array['action'] = $param;
					}
					else {
						list( $k, $v ) = explode( ':', $param );

						if ( $k == 'limit' ) {
							$array['limit'] = $v;
						}
						elseif ( $k == 'page' ) {
							$array['page'] = $v;
						}
						elseif ( $k == 'admin' ) {
							$array['admin'] = true;
							$array['module'] = $v;
						}
						elseif ( $k == 'ajax' ) {
							$array['ajax'] = true;
							$array['module'] = $v;
						}
						elseif ( $v == 'asc' || $v == 'desc' ) {
							$array['order'][] = $k;
							$array['order'][] = $v;
						}
						else {
							$array['where'][$k] = urldecode( $v );
							$array[':'.$k] = urldecode( $v );
						}
					}
				}
			}
		}

		if ( !isset( $array['module'] ) ) {
			$array['module'] = _MODULE;
		}

		if ( !isset( $array['action'] ) ) {
			$array['action'] = _ACTION;
		}

		if ( !isset( $array['page'] ) ) {
			$array['page'] = 1;
		}

		if ( !isset( $array['limit'] ) ) {
			$array['limit'] = _LIMIT;
		}

		return $array;
	}

	public static function url2appli ( $params ) {
		$appli = array();

		if ( is_array( $params ) ) {
			if ( isset( $params['module'] ) ) {
				$module = $params['module'];

			//	$appli['from'] = $module.' '.$module[0];
			}

			if ( isset( $params['limit'] ) && !isset( $params['page'] ) ) {
				$start = 0;
				$end = $params['limit'];

				$appli['limit'] = "$start, $end";
			}
			elseif ( isset( $params['page'] ) && !isset( $params['limit'] ) ) {
				$start = ( $params['page'] - 1 ) * _LIMIT;
				$end = $params['limit'];

				$appli['limit'] = "$start, $end";
			}
			elseif ( isset( $params['page'] ) && isset( $params['limit'] ) ) {
				$start = ( $params['page'] - 1 ) * $params['limit'];
				$end = $params['limit'];

				$appli['limit'] = "$start, $end";
			}

			if ( isset( $params['order'] ) ) {
				$appli['orderby'] = $params['order'][0].' '.$params['order'][1];
			}

			if ( isset( $params['where'] ) ) {
				if ( count( $params['where'] ) > 0 ) {
					foreach ( $params['where'] as $k => $v ) {
						if ( $v ) {
							$v = urldecode( $v );
							$appli['where'][] = "$module.$k = '$v'";
						}
					}
				}
			}
		}

		return $appli;
	}

	public static function redirect ( $url = 1 ) {
		if ( is_integer( $url ) ) {
			$url = self::previous( $url );
		}

		header( 'location: '.str_replace( DS, '/', $url ) );exit;
	}

	public static function previous ( $i = 1 ) {
		global $_SESSION;

		return $_SESSION['history'][$i];
	}
}