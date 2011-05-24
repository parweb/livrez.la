<?php

class link {
	static public function href ( $module = _MODULE, $action = _ACTION, $params = array() ) {
		if ( @preg_match( '#/#', $module ) ) {
			$url = URL.trim( $module, '/' ).'/';
		}
		else {
			$out_params = '';
			if ( count( $params ) > 0 ) {
				foreach ( $params as $param_key => $param_val ) {
					$out_params .= "$param_key:$param_val/";
				}
			}

			$url = str_replace( DS, '/', URL.$module.'/'.$action.'/'.$out_params );
		}

		return $url;
	}
}