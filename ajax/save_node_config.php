<?php
session_start();

if ( empty($_SESSION['user_id']) )
	die('!user_id');

define( 'DC', TRUE);

define( 'ABSPATH', dirname(dirname(__FILE__)) . '/' );

set_time_limit(0);

//require_once( ABSPATH . 'includes/errors.php' );
require_once( ABSPATH . 'db_config.php' );
require_once( ABSPATH . 'includes/autoload.php' );

$db = new MySQLidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

if (!node_admin_access($db))
	die ('Permission denied');

if ( !check_input_data ($_REQUEST['in_connections_ip_limit'] , 'int') )
	die('error in_connections_ip_limit');
$in_connections_ip_limit = intval($_REQUEST['in_connections_ip_limit']);

if ( !check_input_data ($_REQUEST['in_connections'] , 'int') )
	die('error in_connections');
$in_connections = intval($_REQUEST['in_connections']);

if ( !check_input_data ($_REQUEST['out_connections'] , 'int') )
	die('error out_connections');
$out_connections = intval($_REQUEST['out_connections']);

if ( !check_input_data ($_REQUEST['auto_reload'] , 'int') )
	die('error auto_reload');
$auto_reload = intval($_REQUEST['auto_reload']);

if ( !check_input_data ($_REQUEST['pool_admin_user_id'] , 'int') )
	die('error pool_admin_user_id');
$pool_admin_user_id = intval($_REQUEST['pool_admin_user_id']);

$cf_url = $db->escape($_REQUEST['cf_url']);
$pool_url = $db->escape($_REQUEST['pool_url']);
$exchange_api_url = $db->escape($_REQUEST['exchange_api_url']);

define('MY_PREFIX', get_my_prefix($db));

$db->query( __FILE__, __LINE__,  __FUNCTION__,  __CLASS__, __METHOD__, "
		UPDATE `".DB_PREFIX."config`
		SET  `in_connections_ip_limit` = {$in_connections_ip_limit},
				`in_connections` = {$in_connections},
				`out_connections` = {$out_connections},
				`cf_url` = '{$cf_url}',
				`pool_url` = '{$pool_url}',
				`pool_admin_user_id` = {$pool_admin_user_id},
				`exchange_api_url` = '{$exchange_api_url}',
				`auto_reload` = {$auto_reload}
		");
$config_ini = $_POST['config_ini'];
if (!parse_ini_string($config_ini))
	die('error config_ini');

@file_put_contents( ABSPATH . 'config.ini', $config_ini );

?>