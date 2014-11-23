<?php
	
	require_once( $_SERVER['DOCUMENT_ROOT'] .'/system/load.php');		//XHTML Skeleton
	
	
	if(isset($_GET['action'])) {
		
		if($_GET['action'] === 'out') {
			Friends::cleanAcceptedRequests();
			session_start();
			$_SESSION = array();
			setcookie(session_name(), '', time()-2592000, '/');
			session_destroy();
			header('location: /login.php');
			exit();
		}
	}else if(isset($_POST['username'])) {
		
			
			if(!Users::authentication($_POST['username'], $_POST['password'], true)){
				$_SESSION['message'] = 'Invalid username password';
				header('location: /login.php');
				exit();
			}else{
				
				if($_SESSION['user']['role'] === '0'){
					header('location: dashboard.php');
					exit();
				}else{
					header('location: /admin/manage-store.php');
					exit();
				}
				
			}
		
	} else {
		if(isset($_SESSION['user'])){
			header('location: /my-info.php');
			exit();
		}else{
			$content =  (isset($_SESSION['message']) ? $_SESSION['message'] : '') .
						Users::login_form();
			unset($_SESSION['message']);  
		}
    }

				
	$html = new Html();
	$html->set_title('Login');
	$html->set_content('<div class="container">'. $content . '</div>');
	$html->display();

	
?>