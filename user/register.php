<?php 
require('../configuration/db-connection.php');

$successMessage = "";

if (isset($_POST['register'])) { 

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password_1 = $_POST['password_1'];
  $password_2 = $_POST['password_2'];

  $errors = array();

  if (empty($username)) {
    array_push($errors, "username is empty");
  }
  if (empty($email)) {
    array_push($errors, "email is empty");
  }
  if (empty($password_1)) {
    array_push($errors, "password is empty");
  }
  if (empty($username)) {
    array_push($errors, "username is empty");
  }
  if (strlen($password_1) <= 6){
    array_push($errors, "Choose a password longer then 6 character");
  }
  if ($password_1 != $password_2) {
    array_push($errors, "Different passwords");
  }

  $query = $pdo->prepare('SELECT * FROM users WHERE username = :username');
  $query->execute(compact('username'));

  if ($query->rowCount()) {
    array_push($errors, "Username already reserved");
  }

  $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
  $query->execute(compact('email'));

  if ($query->rowCount()) {
    array_push($errors, "Email already reserved");
  }

  if (count($errors) == 0) {
    $password = md5($password_1);
    $query = "INSERT INTO users VALUES(NULL , :username, :email, :password,  NOW())";
    $data = $pdo->prepare($query);
    $data->execute([
      'username' => $username,
      'email' => $email,
      'password' =>$password
    ]);

    $successMessage = "You sucessfully registered. You can log in now. <a href='/user/login.php'>Log In</a>";
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body class="body-height" >
  <header class="head" ></header>
  <div  class="container">

    <h3 class="reg">Регистрация</h3>

    <form class="form" action="" method="post">
      <?php echo $successMessage; ?>
      <?php include('../error.php') ?>
      <div class="form-group">
        <label>Email:</label>
        <input  type="email" 
        class="form-control" 
        placeholder="Enter email"
        name="email" 
        value="<?php echo $email; ?>">
      </div>
      <div class="form-group">
        <label>Username:</label>
        <input  type="text"
        class="form-control" 
        placeholder="Enter username" 
        name="username"
        value="<?php echo $username; ?>">
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input  type="password" class="form-control" placeholder="Enter password" name="password_1">
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input  type="password" class="form-control" placeholder="Re password" name="password_2">
      </div>
      <button name="register" type="submit" class="btn btn-default">Submit</button>
      <button  type="button" class="btn btn-default cancel">  <a style="text-decoration: none; color: black;" href="../index.php">cancel</a></button>
    </form>

  </div>
  <?php  require('../footer.php');?>
