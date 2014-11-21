<?php 
class Graduates{
			
		static function listing(){
			
			$query = MYSQL::query('SELECT first_name, last_name, graduation_year, USER_ID, profile_image, degree_type.description as degree FROM graduate JOIN degree_type on graduate.DEGREE_ID = degree_type.DEGREE_ID');
			
			$content = '<table>
						<tr><th></th><th>First Name</th><th>Last Name</th><th>Degree</th><th>Graduation Year</th><th></th></tr>';
			
			while($graduate = $query->fetch_assoc()){
				if(empty($graduate['USER_ID'])){
					$friendship = 'Not a registered member';
				}else{
					//check if they are already friends
					$friend = MYSQL::query('SELECT USER_ID from friends WHERE USER_ID = ' . $_SESSION['user']['ID'] . ' AND FRIEND_ID = ' . $graduate['USER_ID']);
					//check if a friend request was already sent
					$request = MYSQL::query('SELECT USER_ID from friend_requests WHERE USER_ID = ' . $_SESSION['user']['ID'] . ' AND FRIEND_ID = ' . $graduate['USER_ID']);
					//check if a request is waiting
					$friend_request = MYSQL::query('SELECT USER_ID from friend_requests WHERE FRIEND_ID= ' . $_SESSION['user']['ID'] . ' AND USER_ID =' . $graduate['USER_ID']);
					
					
					if($friend->num_rows == 1){
						$friendship = 'Friend';
					}else if($request->num_rows == 1){
						$friendship = 'Friend Request Sent';
					}else if($_SESSION['user']['ID'] == $graduate['USER_ID']){
						$friendship = 'ME';
					}else if($friend_request->num_rows === 1){
						$friendship = '<a href="/friends?action=friend-requests">Waiting for friend response</a>';
					}else{
						$friendship = '<a href="/friends.php?action=add-friend&id='. $graduate['USER_ID'] .'">Add Friend<a/>';
					}
				}
				
				$content .= '<tr>
								<td></td>
								<td>'. $graduate['first_name'] .'</td>
								<td>'. $graduate['last_name'] .'</td>
								<td>'. $graduate['degree'] .'</td>
								<td>'. $graduate['graduation_year'] .'</td>
								<td>'. (isset($_SESSION['user']) ? $friendship : '') .'</td>
							</tr>';
			}
			
			$content .= '</table>';	
			
			
			return $content;
		}
		
	
}
