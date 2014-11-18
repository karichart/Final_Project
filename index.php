<?php
	require_once($_SERVER['DOCUMENT_ROOT'] .'/system/load.php');
	
	$content = '
				<div class="container" id="home-banner">					
					<h1 class="uppercase" id="welcome-message">Welcome to Computer Science</h1>
					
				</div>
				<div class="container">
					<p>	Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
							Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, 
							when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
							It has survived not only five centuries, but also the leap into electronic typesetting, 
							remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset 
							sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like 
							Aldus PageMaker including versions of Lorem Ipsum.
					</p>
				</div>';
	$html = new Html();
	$html->set_title('Home');
	$html->set_content($content);
	$html->display();
	
