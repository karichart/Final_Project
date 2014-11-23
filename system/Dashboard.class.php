<?php

class Dashboard{
		
	static function display(){
		$query = MYSQL::query('SELECT * FROM friend_requests JOIN graduate on friend_requests.TO_USER = graduate.USER_ID WHERE friend_requests.FROM_USER = '. $_SESSION['user']['ID'] .' AND status = 1');
		$content = '';
		if($query->num_rows > 0){
			$content = '<h1>New friends!</h1>';
			
			while($friend = $query->fetch_assoc()){
					
				//add image and link to profile
				$content .= $friend['first_name'] . ' ' . $friend['last_name'];
			}
		}else{
			$content = 'No news';
		}
		
		return $content;			
	}
}
