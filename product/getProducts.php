<?php 
session_start();
require('../configuration/db-connection.php'); 
if(isset($_SESSION["username"])) {
	$perPage = $_GET['perPage'];
	$page = $_GET['page'];
	$category_id = $_GET['category_id'];

	$limit = ($perPage && $page) ? 
	' LIMIT ' . $perPage . ' OFFSET ' . ($page - 1) * $perPage  :
	'';

	$userId = $_SESSION['id'];

	$statement2 = $pdo->prepare("SELECT count(*) FROM products where user_id = :userId");
	$statement2->execute(compact('userId'));

	$totalRows = $statement2->fetchColumn();
	
	$search = $_GET['search'];
	
	$params = ['user_id' => $userId];
	$query = "SELECT * FROM products "; 
	$isExistWhere = false;

	if ($category_id) {
		$query .= "INNER JOIN products_categories ON products.id = products_categories.product_id WHERE category_id = :category_id ";
		$params["category_id"] = $category_id;
		$isExistWhere = true;
	}

	if ($search) {
		$params['search'] = "%" . $search . "%";
		$query .= ($isExistWhere ? "and" : "where") . " (name like :search or description like :search) ";
		$isExistWhere = true;
	}

	$query .= ($isExistWhere ? "and" : "where") . " user_id = :user_id ". $limit;
	$statement=$pdo->prepare($query);
	$statement->execute($params);
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$products = $statement->fetchAll();




	echo json_encode(compact('products', 'totalRows'));

}else {
	header("HTTP/1.1 401 Unauthorized");
	echo 'залогинся1';
}







?>





