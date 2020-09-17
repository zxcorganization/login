<?php 
require('../configuration/db-connection.php'); 
session_start();
if(isset ($_SESSION["username"])) {
	// $query = "SELECT * FROM products WHERE id = :id ";  
	// $statement2 = $pdo->prepare($query);
	// $statement2->execute([
	// 'id' => $_POST["id"]]); 
	// $count = $statement2->rowCount();  
	if(isset($_GET["id"])) {  

		if ($_GET["id"]) {
			$statement = $pdo->prepare("SELECT * FROM products  WHERE  id = :id ");
			$statement->execute(['id' => $_GET["id"]]);
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$product = $statement->fetch();

			$statement = $pdo->prepare("SELECT category_id FROM products_categories WHERE product_id = :product_id ");
			$statement->execute(['product_id' => $_GET["id"]]);
			$statement->setFetchMode(PDO::FETCH_COLUMN, 0);
			$category_ids = $statement->fetchAll();

			$product['category_ids'] = $category_ids;

			echo json_encode($product);

		}			
		

	}
else {  
		echo 'a net';  
	}  


}else {
	header("HTTP/1.1 401 Unauthorized");
	echo 'залогинся1';
}
?>