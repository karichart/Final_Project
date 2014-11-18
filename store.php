<?php

	require_once($_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
		$content = Store::frontEndListing();
	
	

	$html = new Html();
	$html->set_title('Store');
	$html->set_content('<div class="container">' . $content .'</div>');
	$html->display();
	
