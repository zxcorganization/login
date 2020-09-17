<?php  
     session_start(); 

try  
{   
  require('../configuration/db-connection.php');

  if(isset($_POST["login"])) {  
    if(empty($_POST["username"]) || empty($_POST["password"])) {  
      $message = 'All fields are required';  
    } else {
      $query = "SELECT * FROM users WHERE username = :username AND password = :password";  
      $statement = $pdo->prepare($query);
      $statement->execute([
        'username' => $_POST["username"],  
        'password' => md5($_POST["password"])
      ]); 
      $user = $statement->fetch(PDO::FETCH_ASSOC); 
      $count = $statement->rowCount();  
      if($count > 0) {  
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["id"] = $user["id"];
        
        header("location:../index.php");  
      } else {  
        $message = 'Username OR Password is wrong';  

      }  
    }  
  }  
} catch(PDOException $error) {  
  $message = $error->getMessage();  
}  

?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body class="body-height" >
<header class="head" ></header>
<div  class="container">

<h3 class="enter">Вход</h3>
<form  class="form" method="post">
<?php if(isset($message)) {
    echo  '<div class=" error">' . '<label class=" text-danger ">'. $message .'</label>' . '</div>';  
}  
?>  
  <div class="form-group">
    <label for="username">Username:</label>
    <input   type="text" class="form-control" id="username" placeholder="Enter username" name="username">
  </div>
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
  </div>
  <a href="http://login/sendcode.php">Forgot password</a>
  <div class="checkbox">
    <label><input type="checkbox" name="remember"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default" name="login">Submit</button>
  <button  type="button" class="btn btn-default cancel">  <a style="text-decoration: none; color: black;" href="../index.php">cancel</a></button>
</form>
</div>

<?php  require('../footer.php');?>