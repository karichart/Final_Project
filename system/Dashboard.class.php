<?php

class Dashboard{
		
	static function display(){
		$query = MYSQL::query('SELECT * FROM friend_requests JOIN graduate on friend_requests.FRIEND_ID = graduate.USER_ID WHERE friend_requests.USER_ID = '. $_SESSION['user']['ID'] .' AND status = 1');
		$content = '';
		if($query->num_rows > 0){
			$content = '<h1>New friends!</h1>';
			
			while($friend = $query->fetch_assoc()){
					
				//add image and link to profile
				$content .= $friend['first_name'] . ' ' . $friend['last_name'];
			}
		}
		
		return $content;			
	}
}
