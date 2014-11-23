<?php
date_default_timezone_set('America/Denver');

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once(ROOT . '/system/Html.class.php');	
require_once(ROOT . '/system/MYSQL.class.php');	
require_once(ROOT . '/system/Form.class.php');	
require_once(ROOT . '/system/Users.class.php');	
require_once(ROOT . '/system/Store.class.php');	
require_once(ROOT . '/system/System.class.php');	
require_once(ROOT . '/system/Graduates.class.php');
require_once(ROOT . '/system/Friends.class.php');	
require_once(ROOT . '/system/Dashboard.class.php');	
require_once(ROOT . '/system/Messages.class.php');	


session_start();


?>