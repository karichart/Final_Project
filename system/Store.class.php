<?php
class Store {
			
	static function listing(){
		$query = MYSQL::query('SELECT * FROM items JOIN users ON items.added_by = users.USER_ID');	
		
		$content = '<div class="container">
						<h1>Inventory</h1>
						<a href="/admin/manage-store?action=add-item">Add Item</a>
						';
		
		if($query->num_rows > 0){
			$content .= '<table>
						<tr><th></th><th>Item</th><th>Description</th><th>Price</th><th>Quantity Available</th><th>Added On</th><th>Added by</th><th></th></tr>';
			
			while($item = $query->fetch_assoc()){
				$content .= '<tr>
								<td>
									<img src="'. $item['image'] .'">
								</td>
								<td>'. $item['name'] .'</td>
								<td>'. $item['description'] .'</td>
								<td>'. $item['price'] .'</td>
								<td>'. $item['quantity'] .'</td>
								<td>'. date('F d, Y', strtotime($item['added_on'])) .'</td>
								<td>'. $item['first_name'] . ' ' . $item['last_name'] .'</td>
								<td><a href="/admin/manage-store?action=delete-item&id='. $item['ITEM_ID'] .'">Delete</a></td>
								<td><a href="/admin/manage-store?action=edit-item&id='. $item['ITEM_ID'] .'">Edit</a></td>
							</tr>';
			}
			
			$content .= '<table>
						</div>';
		}else{
			$content .= 'There are no items available';
		}
					
					
		
		return $content;
	}	
	
	static function deleteItemConfirmation($item_id){
		$query = MYSQL::query('SELECT * FROM items WHERE ITEM_ID = ' . $item_id)->fetch_assoc();
		
		$content = '<h1>Are you sure you want to delete the following item?</h1>
					<img src="'. $query['image'] .'" alt="'.$query['name'] .'">
					Item: ' . $query['name'] . '</br>
					Description: ' . $query['description'] . '</br>
					Price: ' . $query['price'] . '</br>
					Quantity Available: ' . $query['quantity'] . '</br>
					<a href="/admin/manage-store?action=deleting-item&id='. $query['ITEM_ID'] .'" class="btn-primary">Yes, Delete</a>
					</br>
					<a href="/admin/manage-store" class="btn-primary">No, Take me back</a>';
		return $content;
		
	}
	
	static function deleteItem($item_id){
		return MYSQL::query('DELETE FROM items WHERE ITEM_ID = ' . $item_id); 
	}
	
	static function addItemForm($item_id = null){
		if(!empty($item_id)){
			$item_data = MYSQL::query('SELECT * FROM items WHERE ITEM_ID = ' . $item_id)->fetch_assoc();
			$title = 'Update <em>' . $item_data['name'] . '</em>';
			$button = 'Udate ' . $item_data['name']; 
			$action = '/admin/manage-store.php?action=editing-item&id=' . $item_id;
			
		}else{
			$item_data = null;
			$title = 'Add New Item';
			$button = 'Add Item';
			$action = '/admin/manage-store.php?action=adding-item';
		}	
		
		$form = new Form($action , 'post', '' , true);
		
		$form->raw('<div class="centered-form gray-background round-box">');
		
		$form->title($title);
		
		if(!empty($item_id)){
			$form->raw('<img src="'. $item_data['image'] .'" alt="'. $item_data['name'] .'"/>');
			$form->br();
		}
		
		$form -> label('Name');
		$form -> input('text', 'name', $item_data['name']);
		$form->br();
		$form -> label('Description: ');
		$form -> input('text', 'description', $item_data['description']);
		$form->br();
		$form -> label('Number of items Available: ');
		$form -> input('text', 'quantity', $item_data['quantity']);
		$form->br();
		$form -> label('Price: ');
		$form -> input('text', 'price', $item_data['price']);
		$form->br();
		$form -> label('Image: ');
		$form -> input('file', 'image');
		$form->br();
		$form -> submit($button);
		$form->raw('</div>');
		
		return $form -> display();
	}
	
	static function addItem($name, $description, $quantity, $price, $added_by, $image){
		$query = MYSQL::query('INSERT INTO items(name, description, quantity, price, added_by)
				VALUE("'. $name .'", "'. $description .'", "'. $quantity .'", "'. $price .'", "'. $added_by .'")');
		
		if($query){
			if(!empty($image)){
				$item_id = MYSQL::last_id();
				$extension = explode('/', $image['type']);
				$image_path =  '/media/store-items/' . $name . '-' . $item_id . '.' . $extension[1];
				rename($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
				chmod($_SERVER['DOCUMENT_ROOT'] . $image_path, 0777);
				
				$query = MYSQL::query('UPDATE items SET image = "'. $image_path .'" WHERE ITEM_ID = ' . $item_id);
						
			}
		
		}
	
	}
	
	static function updateItem($item_id, $name, $description, $quantity, $price, $image){
		if(!empty($image)){
				$extension = explode('/', $image['type']);
				$image_path =  '/media/store-items/' . $name . '-' . $item_id . '.' . $extension[1];
				rename($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $image_path);
				chmod($_SERVER['DOCUMENT_ROOT'] . $image_path, 0777);
		}	
		
		$query = MYSQL::query('UPDATE items set 
					name = "'. $name .'", 
					description = "'. $description .'",
					quantity= "'. $quantity .'",
					price= "'. $price .'",
					' . (!empty($image) ? 'image="'. $image_path .'"' : '') .
					'WHERE ITEM_ID = ' . $item_id);
		
	}
	
	static function frontEndListing(){
		$query = MYSQL::query('SELECT * FROM items');
		$content = '';
		
		while($item = $query->fetch_assoc()){
			$image = (empty($item['image']) ? '/media/photo_not_available.png' :  $item['image']) ;			
			$content .= '<div class="col-4 gray-background">
							<div class="item-img">
								<img src="'. $image .'" alt="'. $item['name'] .'" class="img-width"/>
							</div>
							<h3>'. $item['name'] .'</h3>
							<p>Price: $'. $item['price'] .'</p>
							<p>Description: '. $item['description'] .'</p>
							<a href="#">Add To Cart</a>
						</div>';		
		}
					
		return $content;
			
		
	}
}