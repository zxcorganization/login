<?php 
require('../configuration/db-connection.php'); 


  $statement = $pdo->prepare(
   "DELETE FROM  products  WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );

  if(!empty($result))
  {
   echo 'Data Deleted';
 }


 ?>