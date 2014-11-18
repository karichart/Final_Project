<?php
	require_once( $_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	if(!isset($_SESSION['user'])){
		$_SESSION['destination'] = 'my-info.php';
		$_SESSION['message'] .= '<h1>Please Login Before Continue</h1>';
		header('location: /karichart/r1ch4r7/login.php');
		exit();
	}else{
		unset($_SESSION['destination']);  
		$content = '<h1>My Info</h1>
					Name: ' . $_SESSION['user']['first'] .  $_SESSION['user']['last'] .
					'</br>
					Email: ' .  $_SESSION['user']['email'] ;
	}
	

	$html = new Html();
	$html->set_title('My Info');
	$html->set_content('<div class="container">' . $content . '</div>');
	$html->display();
	
