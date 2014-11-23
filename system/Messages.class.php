<?php 
class Messages{
	static function messageForm($friend_id){
		$form = new Form('/friends.php?action=save-message&id=' . $friend_id);
		
		$form->label('Message');
		$form->br();
		$form->input('text', 'message');
		
		$form->submit('Send Message');
		
		return $form->display();
		
	}
	
	static function sendMessage($friend_id, $message){
		return MYSQL::query('INSERT INTO messages (USER_ID, FRIEND_ID, message) VALUES('. $_SESSION['user']['ID'] .','. $friend_id .', "'. $message .'")');
	}
	
	static function myMessages(){
		
	}
	
	
}