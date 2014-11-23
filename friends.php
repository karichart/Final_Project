<?php

	require_once( $_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	if(!isset($_GET['action'])){
		$content = Friends::listMyFriends();
	}else if($_GET['action'] === 'add-friend'){
		if(Friends::addFriendRequest($_GET['id'])){
			System::message('Your friend request has been sent!', '/graduates.php');
		}else{
			System::message('There was a problem sending your request, please try again', '/graduates.php');
		}
	}else if($_GET['action'] === 'friend-requests'){
		$content = Friends::listRequests();	
	}else if($_GET['action'] === 'accept-request'){
		$query = MYSQL::query('SELECT * FROM graduate WHERE USER_ID = ' . $_GET['id'])->fetch_assoc();	
			
		if(Friends::acceptRequest($_GET['id'])){
			System::message('Congratulations, you are know friends with ' . $query['first_name']. ' ' . $query['last_name'], '/friends.php');
		}else{
			System::message('You denied friend request from ' . $query['first_name'] . ' ' . $query['last_name'], '/friends.php');
		}
	}else if($_GET['action'] === 'deny-request'){
		$query = MYSQL::query('SELECT * FROM graduate WHERE USER_ID = ' . $_GET['id'])->fetch_assoc();	
		if(Friends::denyRequest($_GET['id'])){
			System::message('You have denied ' . $query['first_name']. ' ' . $query['last_name'] . '\'s request', '/friends.php');
		}else{
			System::message('There was a problem denying the request', '/friends.php?action=friend-requests');
		}
	}else if($_GET['action'] === 'new-message'){
		$content = Messages::messageForm($_GET['id']);
	}else if($_GET['action'] === 'save-message'){
		if(Messages::sendMessage($_GET['id'], $_POST['message'])){
			System::message('Your message has been sent', '/friends.php?action=list-messages');
		}else{
			System::message('There was a problem sending your message, please try again', '/friends.php?action=list-messages');
		}
	}else if($_GET['action'] === 'list-messages'){
		$content = 'list messages';
	}
	
	

	$html = new Html();
	$html->set_title('My Info');
	$html->set_content('<div class="container">' . $content . '</div>');
	$html->display();