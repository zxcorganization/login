<?php
session_start();
require('configuration/db-connection.php');
require('header.php');


?>
<?php
function utf8mail($to, $s, $body)
{	
	$from_name="Сброс пароля на login.php";
	$from_a = "skutirev@gmail.com";
	$reply="skutirev@gmail.com";
	$s= "=\?utf-8?b?".base64_encode($s)."?=";
	$headers = "MIME-Version: 1.0\r\n";
	$headers.= "From: =?utf-8?b?".base64_encode($from_name)."?= <".$from_a.">\r\n";
	$headers.= "Content-Type: text/plain;charset=utf-8\r\n";
	$headers.= "Reply-To: $reply\r\n";  
	$headers.= "X-Mailer: PHP/" . phpversion();
	mail($to, $s, $body, $headers);
}
if (!empty($_POST["username"])) {
	if (isset($_POST['login'])) {

		$query_email = "SELECT email FROM users WHERE username = :username ";  
		$statement = $pdo->prepare($query_email);
		$statement->execute([
			'username' => $_POST["username"]
		]);
		$row = $statement->fetchColumn();


		$query_user_id = "SELECT id FROM users WHERE username = :username ";  
		$statement2 = $pdo->prepare($query_user_id);
		$statement2->execute([
			'username' => $_POST["username"]
		]);
		$user_id = $statement2->fetchColumn();

	}	
	if (isset($user_id)) {
		if (isset($row)) {
			echo "вам на почту отправили код. Перейдите по ссылке для  <a href='http://login/changepassword.php' >востановления пароля</a> ";
			$code = uniqid();

			utf8mail($row, "Сброс пароля " ,"Ваш код для сброса: ".$code);
		
			$used_at = $pdo->prepare(
				"UPDATE reset_password 
				SET used_at = NOW()
				WHERE user_id = :user_id
				");

			$result_used_at = $used_at->execute(
				[
					':user_id'	=>$user_id
				]
			);

			$statement3 = $pdo->prepare(
				"INSERT INTO reset_password VALUES(NULL, :user_id ,NOW(), NULL, :code  )");

			$result3 = $statement3->execute(
				[
					':code' =>$code,
					':user_id'	=>$user_id
				]
			);
		}
		
	}
}
?>
<div  class="container">
	<h3 class="resetpassword">Forgot your password?</h3>
	<form  class="form" method="post"> 
		<div class="form-group">
			<label for="username">Username:</label>
			<input   type="text" class="form-control" id="username" placeholder="Enter username" name="username">
		</div>
		<button type="submit" class="btn btn-default" name="login">Submit</button>
		<button  type="button" class="btn btn-default cancel">
			<a style="text-decoration: none; color: black;" href="index.php">cancel</a>
		</button>
	</form>
</div>

<?php  require('footer.php');?>		