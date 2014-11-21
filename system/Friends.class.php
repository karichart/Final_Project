<?php 
class Friends{
			
		static function addFriend($friend_id){
			return MYSQL::query('INSERT INTO friend_requests(USER_ID, FRIEND_ID) VALUES("'. $friend_id .'", "'. $_SESSION['user']['ID'] .'")');						
					
		}
		
		static function listRequests(){
			$query = MYSQL::query('SELECT * FROM friend_requests JOIN graduate on friend_requests.USER_ID = graduate.USER_ID WHERE FRIEND_ID = ' . $_SESSION['user']['ID'] . ' AND status = 0');
			
			$content = '<table>
						<tr><th></th><th>From</th><th>Date requested</th><th></th></tr>';
			
			if($query->num_rows > 0){
				while($friend = $query->fetch_assoc()){
							
					$content .= '<tr>
									<td></td>
									<td>'. $friend['first_name'] . ' ' . $friend['last_name'] .'</td>
									<td>'. $friend['date_requested'] .'</td>
									<td>
										<a href="/friends?action=accept-request&id='. $friend['USER_ID'] .'">Accept</a>
										<a href="/friends?action=deny-request&id='. $friend['USER_ID'] .'">Deny</a>
									</td>
								</tr>';	
					
				}
			}
			
			$content .= '</table>'; 
			return $content;
		}
		
		static function acceptRequest($friend_id){
					
			return $query = MYSQL::query('UPDATE friend_requests SET status = 1 WHERE FRIEND_ID = ' . $_SESSION['user']['ID'] . ' AND USER_ID = ' . $friend_id);
		}
		
		static function denyRequest(){
			return $query = MYSQL::query('DELETE FROM friend_requests WHERE FRIEND_ID = ' . $_SESSION['user']['ID'] . ' AND USER_ID = ' . $friend_id);
		}
		
		static function sendMessage(){
			
		}
		
		static function cleanAcceptedRequests(){
			$query = MYSQL::query('DELETE FROM friend_requests WHERE USER_ID = ' . $_SESSION['user']['ID'] . ' AND status = 1');
		}
	
}
