<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

define( '_MODULE', 'page' );
define( '_ACTION', 'list' );

define( '_LIMIT', 20 );
define( 'AUTH', true );

require 'core/index.php';