<?php

session_start();

define( 'DC', TRUE);

define( 'ABSPATH', dirname(__FILE__) . '/' );

set_time_limit(0);

require_once( ABSPATH . 'includes/autoload.php' );

$lang = get_lang();
require_once( ABSPATH . 'lang/'.$lang.'.php' );

//$db = new MySQLidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

//$tpl['title'] = 'Авторизация';
//print_R($_SESSION);
//if ( !empty($_SESSION['user_id']) ) {
//	$tpl['main_include'] = 'login.tpl';
//}else{


require_once( ABSPATH . 'templates/index.tpl' );
//}



?>