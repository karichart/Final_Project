<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	$content = Graduates::listing();
				
	$html = new Html();
	$html->set_title('About Us');
	$html->set_content($content);
	$html->display();
	
