<?php 
class Friends{
			
		static function addFriendRequest($friend_id){
			return MYSQL::query('INSERT INTO friend_requests(FROM_USER, TO_USER) VALUES("'. $_SESSION['user']['ID'] .'","'. $friend_id .'")');						
					
		}
		
		static function listRequests(){
			$query = MYSQL::query('SELECT * FROM friend_requests JOIN graduate on friend_requests.FROM_USER = graduate.USER_ID WHERE TO_USER = ' . $_SESSION['user']['ID'] . ' AND status = 0');
			
			$content = '<table>
						<tr><th></th><th>From</th><th>Date requested</th><th></th></tr>';
			
			if($query->num_rows > 0){
				while($friend = $query->fetch_assoc()){
							
					$content .= '<tr>
									<td></td>
									<td>'. $friend['first_name'] . ' ' . $friend['last_name'] .'</td>
									<td>'. $friend['date_requested'] .'</td>
									<td>
										<a href="/friends?action=accept-request&id='. $friend['FROM_USER'] .'">Accept</a>
										<a href="/friends?action=deny-request&id='. $friend['FROM_USER'] .'">Deny</a>
									</td>
								</tr>';	
					
				}
			}
			
			$content .= '</table>'; 
			return $content;
		}
		
		static function acceptRequest($friend_id){
					
			if(self::addFriend($friend_id)){
				return $query = MYSQL::query('UPDATE friend_requests SET status = 1 WHERE TO_USER = ' . $_SESSION['user']['ID'] . ' AND FROM_USER = ' . $friend_id);
					
			}else{
				return false;	
				
			}						
		}
		
		static function addFriend($friend_id){
			return MYSQL::query('INSERT INTO friends(USER_ID, FRIEND_ID) VALUES('. $_SESSION['user']['ID'] .', '. $friend_id .')');
		}
		
		static function denyRequest($friend_id){
			return $query = MYSQL::query('DELETE FROM friend_requests WHERE TO_USER = ' . $_SESSION['user']['ID'] . ' AND FROM_USER = ' . $friend_id);
		}
		
		
		static function cleanAcceptedRequests(){
			$query = MYSQL::query('DELETE FROM friend_requests WHERE FROM_USER = ' . $_SESSION['user']['ID'] . ' AND status = 1');
		}
		
		static function listMyFriends(){
			$query = MYSQL::query('SELECT * FROM friends JOIN graduate on friends.FRIEND_ID = graduate.USER_ID WHERE friends.USER_ID = ' . $_SESSION['user']['ID'] . ' OR friends.FRIEND_ID =' . $_SESSION['user']['ID']);
			
			$content = '';
			
			if($query->num_rows > 0){
				while($friend = $query->fetch_assoc()){
					$content .=  $friend['profile_image'] . $friend['first_name'] . ' ' . $friend['last_name'] . ' ' . $friend['friends_since'] . ' <a href="/friends.php?action=new-message&id='. $friend['USER_ID'] .'">Send Message</a>';
				}
			}else{
				return 'You have no friends yet';
			}
			
			return $content;
		}
		
		
}
