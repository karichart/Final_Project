<?php
class Store {

	static function listing() {
		$query = MYSQL::query('SELECT * FROM items JOIN users ON items.added_by = users.USER_ID ');

		$content = '<div class="container">
						<h1>Inventory</h1>
						<a href="/admin/manage-store?action=add-item">Add Item</a>
						';

		if ($query -> num_rows > 0) {
			$content .= '<table>
						<tr><th></th><th>Item</th><th>Description</th><th>Price</th><th>Quantity Available</th><th>Added On</th><th>Added by</th><th></th></tr>';

			while ($item = $query -> fetch_assoc()) {
				$content .= '<tr>
								<td>
									<img src="' . $item['image'] . '">
								</td>
								<td>' . $item['name'] . '</td>
								<td>' . $item['description'] . '</td>
								<td>' . $item['price'] . '</td>
								<td>' . $item['quantity'] . '</td>
								<td>' . date('F d, Y', strtotime($item['added_on'])) . '</td>
								<td>' . $item['username'] . '</td>
								<td><a href="/admin/manage-store?action=delete-item&id=' . $item['ITEM_ID'] . '">Delete</a></td>
								<td><a href="/admin/manage-store?action=edit-item&id=' . $item['ITEM_ID'] . '">Edit</a></td>
							</tr>';
			}

			$content .= '<table>
						</div>';
		} else {
			$content .= 'There are no items available';
		}

		return $content;
	}

	static function deleteItemConfirmation($item_id) {
		$query = MYSQL::query('SELECT * FROM items WHERE ITEM_ID = ' . $item_id) -> fetch_assoc();

		$content = '<h1>Are you sure you want to delete the following item?</h1>
					<img src="' . $query['image'] . '" alt="' . $query['name'] . '">
					Item: ' . $query['name'] . '</br>
					Description: ' . $query['description'] . '</br>
					Price: ' . $query['price'] . '</br>
					Quantity Available: ' . $query['quantity'] . '</br>
					<a href="/admin/manage-store?action=deleting-item&id=' . $query['ITEM_ID'] . '" class="btn-primary">Yes, Delete</a>
					</br>
					<a href="/admin/manage-store" class="btn-primary">No, Take me back</a>';
		return $content;

	}

	static function deleteItem($item_id) {
		return MYSQL::query('DELETE FROM items WHERE ITEM_ID = ' . $item_id);
	}

	static function addItemForm($item_id = null) {
		if (!empty($item_id)) {
			$item_data = MYSQL::query('SELECT * FROM items WHERE ITEM_ID = ' . $item_id) -> fetch_assoc();
			$title = 'Update <em>' . $item_data['name'] . '</em>';
			$button = 'Udate ' . $item_data['name'];
			$action = '/admin/manage-store.php?action=editing-item&id=' . $item_id;

		} else {
			$item_data = null;
			$title = 'Add New Item';
			$button = 'Add Item';
			$action = '/admin/manage-store.php?action=adding-item';
		}

		$form = new Form($action, 'post', '', true);

		$form -> raw('<div class="centered-form gray-background round-box">');

		$form -> title($title);

		if (!empty($item_id)) {
			$form -> raw('<img src="' . $item_data['image'] . '" alt="' . $item_data['name'] . '"/>');
			$form -> br();
		}

		$form -> label('Name');
		$form -> input('text', 'name', $item_data['name']);
		$form -> br();
		$form -> label('Description: ');
		$form -> input('text', 'description', $item_data['description']);
		$form -> br();
		$form -> label('Number of items Available: ');
		$form -> input('text', 'quantity', $item_data['quantity']);
		$form -> br();
		$form -> label('Price: ');
		$form -> input('text', 'price', $item_data['price']);
		$form -> br();
		$form -> label('Image: ');
		$form -> input('file', 'image');
		$form -> br();
		$form -> submit($button);
		$form -> raw('</div>');

		return $form -> display();
	}

	static function addItem($name, $description, $quantity, $price, $added_by, $image) {
		$query = MYSQL::query('INSERT INTO items(name, description, quantity, price, added_by)
				VALUE("' . $name . '", "' . $description . '", "' . $quantity . '", "' . $price . '", "' . $added_by . '")');

		if ($query) {
			if (!empty($image)) {
				$item_id = MYSQL::last_id();
				$extension = explode('/', $image['type']);
				$image_path = '/media/store-items/' . $name . '-' . $item_id . '.' . $extension[1];
				rename($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
				chmod($_SERVER['DOCUMENT_ROOT'] . $image_path, 0777);

				$image = MYSQL::query('UPDATE items SET image = "' . $image_path . '" WHERE ITEM_ID = ' . $item_id);

			}

		}

		return $query;

	}

	static function updateItem($item_id, $name, $description, $quantity, $price, $image) {
		if (!empty($image)) {
			$extension = explode('/', $image['type']);
			$image_path = '/media/store-items/' . $name . '-' . $item_id . '.' . $extension[1];
			rename($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
			chmod($_SERVER['DOCUMENT_ROOT'] . $image_path, 0777);
		}

		$query = 'UPDATE items set 
					name = "' . $name . '", 
					description = "' . $description . '",
					quantity= "' . $quantity . '",
					price= "' . $price . '"
					' . (!empty($image) ? ',image="' . $image_path . '"' : '') . 'WHERE ITEM_ID = "' . $item_id . '"';

		return MYSQL::query($query);

	}

	static function frontEndListing() {
		$query = MYSQL::query('SELECT * FROM items');
		$content = '';
		while ($item = $query -> fetch_assoc()) {
			$image = (empty($item['image']) ? '/media/photo_not_available.png' : $item['image']);
			$content .= '<div class="col-4 gray-background">
							<div class="item-img">
								<img src="' . $image . '" alt="' . $item['name'] . '" class="img-width"/>
							</div>
							<h3>' . $item['name'] . '</h3>
							<p>Price: $' . $item['price'] . '</p>
							<p>Description: ' . $item['description'] . '</p>
							<a href="#" id="' . $item['ITEM_ID'] . '" name="add-item-link">Add To Cart</a>
						</div>';
		}

		return $content;

	}

	static function showCart() {

		if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
			$content = '<h1>Your Shopping Cart is empty.</h1>';

		} else {

			$content = '<h1>Your Cart</h1>';
			$content .= '<table>
					<tr><th></th><th>Item</th><th>Description</th><th>Price</th><th>Quantity</th><th></th></tr>';

			var_dump($_SESSION['cart']);
			foreach ($_SESSION['cart'] as $key => $value) {
				$query = MYSQL::query('SELECT * FROM items WHERE ITEM_ID = ' . $key . ' AND quantity > 0') -> fetch_assoc();
				$content .= '<tr><td><img src="' . $query['image'] . '" alt="' . $query['name'] . '"></td>
							  <td>' . $query['name'] . '</td>
							  <td>' . $query['description'] . '</td>
							  <td>' . $query['price'] . '</td>
							  <td>' . $value . '</td>
							  <td>
							  	<a href="/store?action=remove-item&id=' . $query['ITEM_ID'] . '"  class="remove-item">Remove Item</a>
							  </td></tr>';
			}

			$content .= '</table>
					<a href="#" >Checkout</a>';
		}

		$content .= '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" >
					<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
					<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
		
					';

		return $content;
	}

	//Come back to implement this if you have time
	static function saveCart() {

		foreach ($_SESSION['cart'] as $key => $value) {

			$cart = MYSQL::query('SELECT * FROM cart WHERE USER_ID = "' . $_SESSION['user']['ID'] . '" AND ITEM_ID = "' . $key . '"');
			
			
			if ($cart->num_rows > 0) {
				$cart_info = $cart->fetch_assoc();
				
				$quantity = $cart_info['quantity'] + $value;
				$query = MYSQL::query('UPDATE cart SET quantity = "' . $quantity. '"
									WHERE USER_ID = "' . $_SESSION['user']['ID'] . '"
										AND ITEM_ID = "' . $key . '"');
			} else {
				$query = MYSQL::query('INSERT INTO cart (ITEM_ID, USER_ID, quantity) VALUES("' . $key . '", "' . $_SESSION['user']['ID'] . '", "' . $value . '")');
			}
		}
		/*

		 */

	}

}
