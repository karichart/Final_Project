<?php

	require_once( $_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	$content = Dashboard::display();
	
	

	$html = new Html();
	$html->set_title('My Info');
	$html->set_content('<div class="container">' . $content . '</div>');
	$html->display();