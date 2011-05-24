<?php

// enregistre lheure de départ
$time_start = microtime( true );

// initialisation des sessions
session_start();

define( 'DS', DIRECTORY_SEPARATOR );

$SQL = '';

require_once 'class'.DS.'Beer.php';
//require_once 'class'.DS.'functions.php';

Beer::drink();