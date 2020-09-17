<?php
session_start();
require('../configuration/db-connection.php'); 
if(isset ($_SESSION["username"])) {
  if(isset($_GET["id"])) {  
  $product_id = $_POST["id"];


  $statement = $pdo->prepare(
    "UPDATE products 
    SET name = :name , description = :description 
    WHERE id = :id
    "
  );
  $statement2= $pdo->prepare(
    "DELETE FROM  products_categories  WHERE product_id = :product_id ");
  $result2 = $statement2->execute(
    [
     ':product_id' => $product_id
   ]
 );

  $result = $statement->execute(
    [
     ':name' => $_POST["name"],
     ':description' => $_POST["description"],
     ':id'   => $product_id
   ]
 );

  $categoies = $_POST['category_ids'];

  foreach ($categoies as $category_id) {
    $products_categories_query = "INSERT INTO products_categories (category_id, product_id) VALUES(:category_id ,:product_id)";
    $products_categories_data = $pdo->prepare($products_categories_query);
    $products_categories_data->execute(
      [
       'product_id'   => $product_id,
       'category_id' => $category_id

     ]
   );
  }
 }
 else{echo "net";}
} else {
  header("HTTP/1.1 401 Unauthorized");
    echo 'залогинся1';
}








?>
