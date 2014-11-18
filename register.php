<?php

	require_once($_SERVER['DOCUMENT_ROOT'] .'/system/load.php');		//XHTML Skeleton
	
	if(!empty($_GET)){
		if($_GET['action'] == 'register'){
			
			Users::register($_POST['first'],$_POST['last'],$_POST['email'],$_POST['username'], $_POST['password']);
			if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
				$content = $_SESSION['message'] .
						   Users::register_form();
				$_SESSION['message'] = '';
			}else{
				$content = 'No problem';	
			}
			//$content = Users::register($_POST['user_id'], $_POST['first'],$_POST['last'],$_POST['email'],$_POST['username'], $_POST['password']);
			
		}
	}else{
		if(isset($_SESSION['user'])){
			header('location: /my-info.php');
			exit();
		}else{
			$content = Users::register_form();
		}
	}
		

	$html = new Html();
	$html->set_title('Register');
	$html->set_content('<div class="container">' . $content . '</div>');
	$html->display();
	
