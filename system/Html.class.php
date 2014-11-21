<?php

class Html{
	protected $syles = '';
	protected $scripts = '';
	protected $keywords = '';
	protected $description = '';
	protected $title = '';
	protected $content = '';
	
	
	function display(){
			
		$message = (isset($_SESSION['message']) && !empty($_SESSION['message']) ? $_SESSION['message'] : '');
			
		$_SESSION['message'] = '';
		
		$html = '
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
						<script type="text/javascript" src="/js/main.js"></script>
						<script src="https://www.paypalobjects.com/js/external/apdg.js" type="text/javascript"></script>
						
						
            		<body>
            		
            			<div id="menu" >
		            		<nav role="navigation">		            		  	
			            		  <ul class="navbar-nav container">
			            		  	<li id="cart">
			            		  		<a href="/store?action=view-cart">
			            		  			<img src="/media/shopping-cart.png" alt="shopping cart" />
			            		  			<span id="number-of-items-in-cart">
			            		  				You have '. (isset ($_SESSION['cart']) ? count($_SESSION['cart']) : '') .' items in your cart
			            		  			</span>
			            		  		</a>
			            		  	</li>
			            		  	<li id="logo"><a href="/"><img src="/media/logo.png" alt="Utep Department of computer science logo" /></a></li>
								    
								    '. (isset($_SESSION['user']) && !empty($_SESSION['user']) ? 
								    	'<li id="logout"><a href="/login.php?action=out">Log out</a></li>
								    	 <li id="hello-message"><strong>Hello, '. $_SESSION['user']['first'] .'</strong><li>' :
										  '<li><a href="/login.php">My Account</a></li>') .'
									<li><a href="/store.php">Store</a></li>
									<li><a href="/about-us.php">About</a></li>
									<li><a href="/">Home</a></li>
								</ul>
							</nav>
						</div><div class="clearfix"></div>';
			if(isset($_SESSION['user']) && !empty($_SESSION['user']['username'])){
				$html .= '<div id="admin-menu">
								<ul class="navbar-nav container">
								<li><a href="#">My Profile</a><li>
								<li><a href="#">Messages</a><li>
								<li><a href="#">Friend Requests</a><li>
								
								';
				if( $_SESSION['user']['role'] == 1){
						$html .=	'
									<li><a href="/admin/manage-store.php">Manage Store</a></li>
									
									<li><a href="#">Users</a><li>									
								
							';
					}
					
					$html .= ' 
								</ul></div><div class="clearfix"></div>';
				
				
			}
				$html .=  $message . $this->content .'
           		</body>
           		</html>';
		
		echo $html;
	}
	
	function set_title($title){
		$this->title = $title;
	}
	
	function set_content($content){
		$this->content = $content;
	}
	
	
		
}
?>