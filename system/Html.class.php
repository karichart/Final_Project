<?php

class Html{
	protected $syles = '';
	protected $scripts = '';
	protected $keywords = '';
	protected $description = '';
	protected $title = '';
	protected $content = '';
	
	
	function display(){
		$content = '
			<!DOCTYPE html>
				<html>
					<head>
			            <meta charset="utf-8">
			            <meta name="author" content="Phidev, Inc.">
			            <meta name="robots" content="">
			            <meta name="keywords" content="">
			            <meta name="description" content="">
			            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            			<title>'. $this->title .'</title>
						<link rel="stylesheet" href="/css/main.css" />
						
            		<body>
            		
            			<div id="menu" >
		            		<nav class="navbar navbar-default" role="navigation">
		            		  	<div id="bs-example-navbar-collapse-1">
		            		  	
			            		  <ul class="navbar-nav container">
			            		  	<li id="logo"><a href="/"><img src="/media/logo.png" alt="Utep Department of computer science logo" /></a></li>
								    
								    '. (isset($_SESSION['user']) && !empty($_SESSION['user']) ? 
								    	'<li id="logout"><a href="/login.php?action=out">Log out</a></li>
								    	 <li id="hello-message"><strong>Hello, '. $_SESSION['user']['first'] .'</strong><li>' :
										  '<li><a href="/login.php">My Account</a></li>') .'
									<li><a href="/store.php">Store</a></li>
									<li><a href="/about-us.php">About</a></li>
									<li><a href="/">Home</a></li>
								  </ul>
							  </div>
							</nav>
						</div><div class="clearfix"></div>
						'. $this->content .'
           		</body>
           		</html>';
		
		echo $content;
	}
	
	function set_title($title){
		$this->title = $title;
	}
	
	function set_content($content){
		$this->content = $content;
	}
	
	
		
}
?>