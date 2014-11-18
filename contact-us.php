<?php
	require_once( $_SERVER['DOCUMENT_ROOT'] . '/system/load.php');		//XHTML Skeleton
	
	$content = '<div class="container">
					<h1 class="uppercase">Contact us</h1>
						</br>Phone: (123)456-86-89
						</br>Address: 123 Main St
						</br>Email: contact-us@assignment2.com

				</div>';
				
	$html = new Html();
	$html->set_title('Contact Us');
	$html->set_content($content);
	$html->display();
	
