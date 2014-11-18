<?php
	require_once( $_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	if(!isset($_GET['action'])){
		$content = Store::listing();
	}else if($_GET['action'] === 'add-item'){
		$content = Store::addItemForm();
	
	}else if($_GET['action'] === 'adding-item'){
		$content = '';
		
		$image = (isset($_FILES['image']) && $_FILES['image']['size'] > 0 ? $_FILES['image'] : '');
		
		Store::addItem($_POST['name'], $_POST['description'], $_POST['quantity'], $_POST['price'], $_SESSION['user']['ID'], $image);
	}else if($_GET['action'] === 'delete-item'){
		$content = Store::deleteItemConfirmation($_GET['id']);
		
	}else if($_GET['action'] === 'deleting-item'){
		$content = Store::deleteItem($_GET['id']);

	}else if($_GET['action'] === 'edit-item'){
		$content = Store::addItemForm($_GET['id']);		
	}else if($_GET['action'] === 'editing-item'){
		$content = Store::updateItem($_GET['id'], $_POST['name'], $_POST['description'], $_POST['quantity'],$_POST['price'],(isset($_FILES['image']) && $_FILES['image']['size'] > 0 ? $_FILES['image'] : ''));
	}
			
			
	$html = new Html();
	$html->set_title('Manage Store');
	$html->set_content($content);
	$html->display();
	
