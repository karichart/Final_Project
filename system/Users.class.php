<?php
class Users {


	static function login_form() {
		
		$form = new form();
		$form->raw('<div class="centered-form gray-background round-box">');
		$form->title('Login');
		$form -> label('Username: ');
		$form -> input('text', 'username');
		$form->br(2);
		$form -> label('Password: ');
		$form -> input('password', 'password');
	
		$form->br(2);
		$form -> submit('submit');
		$form->br(2);
		$form -> raw('<a href="/register.php" id="register">Register</a>');
		return $form -> display() . $form->raw('</div>');

	}

	static function authentication($username, $password) {
		$salt = '1jl588yh';
		 
		$query ='SELECT * FROM users WHERE username = "' .  MYSQL::sanitize($username) . '" AND password = "' . hash('ripemd128', $salt .  MYSQL::sanitize($password)) . '"';
			$query = MYSQL::query($query);
			
			if ($query->num_rows > 0) {
				$user = $query->fetch_assoc();
				self::set_user_session($user['USER_ID'], $user['first_name'], $user['last_name'], $user['username'], $user['email'], $user['role']);

				return true;
			}
		

		return false;
	}

	static function register($first, $last, $email, $username, $password) {
	$salt = '1jl588yh';
		if (!empty($first) && !empty($last) && !empty($email) && !empty($username) && !empty($password)) {


			$is_username_available = self::is_username_available($username);
			$is_email_available = self::is_email_available($email);

			if (!$is_username_available || !$is_email_available) {
				return false;
			}

			$query = MYSQL::query('INSERT INTO users(first_name, last_name, email, username, password)
									VALUES("' . MYSQL::sanitize($first) . '",  
											"' . MYSQL::sanitize($last) . '", 
											"' . MYSQL::sanitize($email) . '", 
											"' . MYSQL::sanitize($username) . '",
											"' . MYSQL::sanitize(hash('ripemd128', $salt . $password)) . '")');
			if($query){
				
				$id = MYSQL::last_id();
				
				self::set_user_session($id, $first, $last, $username, $email);
				header('location: /my-info.php');
				exit();
			}else{
				$_SESSION['message'] = 'There was a problem registering, please try again';
				return false;
			}
			

		} else {
			$_SESSION['message'] = 'Please Complete all the fields';
			return false;
		}
	}

	static function is_student($id) {
		$query = MYSQL::query('SELECT * FROM users WHERE USER_ID = ' . MYSQL::sanitize($id));

		if ($query -> num_rows === 1) {
			return true;
		} else {
			$_SESSION['message'] = 'You need to be an student of the class in order to register';
			return false;
		}
	}

	static function is_username_available($username) {
		$query = MYSQL::query('SELECT * FROM users WHERE username = "' . MYSQL::sanitize($username) . '"');

		if ($query -> num_rows > 0) {
			$_SESSION['message'] = 'Username ' . $username . ' is taken';
			return false;
		} else {
			return true;
		}
	}

	static function is_email_available($email) {
		$query = MYSQL::query('SELECT * FROM users WHERE email = "' . MYSQL::sanitize($email) . '"');

		if ($query -> num_rows > 0) {
			$_SESSION['message'] .= '</br>Email ' . $email . ' is taken';
			return false;
		} else {
			return true;
		}
	}


	static function register_form() {

		$form = new Form('/register.php?action=register');
		
		$form->raw('<div class="centered-form gray-background round-box">');
		
		$form->title('Register: ');
		
		$form -> label('First Name: ');
		$form -> input('text', 'first');
		$form->br();
		$form -> label('Last Name: ');
		$form -> input('text', 'last');
		$form->br();
		$form -> label('Email: ');
		$form -> input('text', 'email');
		$form->br();
		$form -> label('Username: ');
		$form -> input('text', 'username');
		$form->br();
		$form -> label('Password: ');
		$form -> input('password', 'password');
		$form->br();
		$form -> submit('Register');
		$form->raw('</div>');
		
		return $form -> display();

	}

	static function set_user_session($user_id, $first, $last, $username, $email, $role) {

		$_SESSION['user'] = array('ID' => $user_id, 'first' => $first, 'last' => $last, 'username' => $username, 'email' => $email, 'role'=>$role);
	}

}
