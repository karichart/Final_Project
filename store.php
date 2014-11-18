<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	if(!isset($_GET['action'])){
		$content = Store::frontEndListing();
			
	}else if($_GET['action'] === 'view-cart'){		
		$content = Store::showCart();
	}else if($_GET['action'] === 'remove-item'){
		$_SESSION['cart'][$_GET['id']]--;
		if($_SESSION['cart'][$_GET['id']] < 0){
			unset($_SESSION['cart'][$_GET['id']]);
		}
		$content = Store::showCart();
	}
	
	

	$html = new Html();
	$html->set_title('Store');
	$html->set_content('<div class="container">' . $content .'</div>');
	$html->display();
	
