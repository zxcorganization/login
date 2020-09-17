<?php 
session_start();
require('../configuration/db-connection.php'); 
if(isset($_SESSION["username"])) {
	$perPage = $_GET['perPage'];
	$page = $_GET['page'];

	$limit = ($perPage && $page) ? 
	' LIMIT ' . $perPage . ' OFFSET ' . ($page - 1) * $perPage  :
	 '';

	$userId = $_SESSION['id'];

	$statement = $pdo->prepare("SELECT * FROM products where user_id = :userId" . $limit);
	$statement->execute(compact('userId'));
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	
	$statement2 = $pdo->prepare("SELECT count(*) FROM products where user_id = :userId");
	$statement2->execute(compact('userId'));

	$products = $statement->fetchAll();
	$totalRows = $statement2->fetchColumn();
	
	echo json_encode(compact('products', 'totalRows'));
}else {
	header("HTTP/1.1 401 Unauthorized");
	echo 'залогинся1';
}
?>





