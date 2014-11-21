//var item_id;

document.addEventListener("DOMContentLoaded", function(event) {
	var add_to_Cart = document.getElementsByName('add-item-link');
	var i = 0;
	var item_ids = [];
	for(i; i < add_to_Cart.length; i++){
			var item = add_to_Cart[i];		
			item_ids[i] = item.id;
			addToCart(item_ids[i]);
	}
	
});
	



function addToCart(item_id){		
		item = document.getElementById(item_id);
		item.addEventListener("click", function(){ajaxFunction(item_id);}, false);		
}

function ajaxFunction(item_id) {
	var ajaxRequest;
	// The variable that makes Ajax possible!

	try {
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		// Internet Explorer Browsers
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}

	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 4) {	
			var cart = document.getElementById('number-of-items-in-cart');
			// cart.innerHTML = 'You have' + ajaxRequest.responseText + ' items in your cart';
		}
	}
	
	ajaxRequest.open("GET", "/services/cart.php?action=add-to-cart&id=" + item_id, true);
	ajaxRequest.send(null); 

}


