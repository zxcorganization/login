<?php
require('configuration/db-connection.php');
require('header.php');


?>
<?php 
$code = $_POST['code'];
$username = $_POST['username'];
$password = $_POST['password'];
$password_1 = $_POST['password_1'];

if (isset($_POST['reset'])) {
	$query = "SELECT * FROM users WHERE username = :username ";  
	$statement = $pdo->prepare($query);
	$statement->execute([
		'username' => $username,
	]);
	if (strlen($password) > 6){
		if (!empty($code)) {
			if (!empty($username)) {
				if ($password == $password_1) {

					$query_user_id2 = "SELECT id FROM users WHERE username = :username ";  
						$statement3 = $pdo->prepare($query_user_id2);
						$statement3->execute([
							'username' => $username
						]);
						$user_id = $statement3->fetchColumn();


						$query_user_id = "SELECT code FROM reset_password WHERE user_id = :user_id AND used_at is NULL  ";  
						$statement2 = $pdo->prepare($query_user_id);
						$statement2->execute([
							'user_id' => $user_id
						]);
						$code = $statement2->fetchColumn();
					if ($_POST['code']= $code) {
						$statement = $pdo->prepare(
							"UPDATE users 
							SET password = :password 
							WHERE id = :user_id
							");
						$result = $statement->execute([
							'password' => md5($password),
							'user_id' => $user_id
						]);
						echo "your password successfuly changed";

					}
					else{
						echo "wrong code";
					}
				}
			}
		}
	}
}else {
	echo "You insert incorrect login or code ";
} 

?>
<div  class="container">
	<h3 class="resetpassword2">Reset password</h3>
	<form  class="form" method="post"> 
		<div class="form-group">
			<label for="username">Username:</label>
			<input   type="text" class="form-control" id="username" placeholder="Enter username" name="username">
		</div>
		<div class="form-group">
			<label for="code">Code:</label>
			<input   type="text" class="form-control" id="code" placeholder="Enter code" name="code">
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input   type="password" class="form-control" id="password" placeholder="Enter password" name="password">
		</div>
		<div class="form-group">
			<label for="password_1">Confirm password:</label>
			<input   type="password" class="form-control" id="password_1" placeholder="Enter password" name="password_1">
		</div>
		<button type="submit" class="btn btn-default" name="reset">Submit</button>
		<button  type="button" class="btn btn-default cancel">
			<a style="text-decoration: none; color: black;" href="index.php">cancel</a>
		</button>
	</form>
</div>

<?php  require('footer.php');?>		