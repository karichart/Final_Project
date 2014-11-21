<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/system/load.php");

if ($_GET['action'] === 'add-to-cart') {
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart'] = array();
		$content = $_GET['id'];
		
	}else{
		 @$_SESSION['cart'][$_GET['id']]++;
		
		
		$content = count($_SESSION['cart']);
		
	}
	
	
} 

echo $content;

