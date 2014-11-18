<?php
	class System{
		static function message($message, $location = ''){
			@$_SESSION['message'] = $message;
			
			if(!empty($location)){
				header('location:' . $location);
				exit();
			}
		}
	}
