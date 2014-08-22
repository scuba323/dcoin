<?php
session_start();

if ( empty($_SESSION['user_id']) )
	die('!user_id');

define( 'DC', TRUE);

define( 'ABSPATH', dirname(dirname(__FILE__)) . '/' );

set_time_limit(0);

//require_once( ABSPATH . 'includes/errors.php' );
require_once( ABSPATH . 'includes/fns-main.php' );
require_once( ABSPATH . 'db_config.php' );
require_once( ABSPATH . 'includes/class-mysql.php' );

$db = new MySQLidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

if (!node_admin_access($db))
	die ('Permission denied');

if ( !check_input_data ($_REQUEST['in_connections_ip_limit'] , 'int') )
	die('error in_connections_ip_limit');

if ( !check_input_data ($_REQUEST['in_connections'] , 'int') )
	die('error in_connections');

if ( !check_input_data ($_REQUEST['out_connections'] , 'int') )
	die('error out_connections');

if ( !check_input_data ($_REQUEST['auto_reload'] , 'int') )
	die('error auto_reload');

define('MY_PREFIX', get_my_prefix($db));

$db->query( __FILE__, __LINE__,  __FUNCTION__,  __CLASS__, __METHOD__, "
		UPDATE `".DB_PREFIX."config`
		SET  `in_connections_ip_limit` = {$_POST['in_connections_ip_limit']},
				`in_connections` = {$_POST['in_connections']},
				`out_connections` = {$_POST['out_connections']},
				`auto_reload` = {$_POST['auto_reload']}
		");

@file_put_contents( ABSPATH . 'config.ini', $_POST['config_ini'] );

?>