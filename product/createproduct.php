<?php 
session_start();
if(isset($_SESSION['username'])){ //if login in session is not set

}else  {
	header("Location: http://login/index.php");
} ?>

<?php  require('../header.php');?>
<?php require('../configuration/db-connection.php'); ?>
<?php 

$successMessage = "";

if (isset($_POST['create'])) { 

	$name = $_POST['name'];

	$description = $_POST['description'];
	$categories = $_POST['categories'];

	
	$errors = array();
	
	if (empty($name)) {
		array_push($errors, "name is empty");
	}
	if (empty($description)) {
		array_push($errors, "description is empty");
	}

	if(empty($categories) || !is_array($categories) || !count($categories)) {
		array_push($errors, "category is empty");
	}


	if (count($errors) == 0) {
		$successMessage = "Posted";
		$products_query = "INSERT INTO products VALUES(NULL,:id ,:name ,:description ,NOW() ,NOW())";


		$products_data = $pdo->prepare($products_query);

		$products_data->execute([
			'id' => $_SESSION['id'],
			'name' => $name,
			'description' => $description]);	

		if ( $pdo->prepare($products_query)) {
			$product_id = $pdo->lastInsertId();
		}

		foreach ($categories as $category_id) {
			$products_categories_query = "INSERT INTO products_categories (category_id, product_id) VALUES(:category_id ,:product_id)";
			$products_categories_data = $pdo->prepare($products_categories_query);
			$products_categories_data->execute(compact('category_id', 'product_id'));	
		}
	
	}
}
	$statement = $pdo->prepare("SELECT * FROM categories");
	$statement->execute();
	$categories = $statement->fetchAll();

?>

<form class="form" method="post">
	<?php include('../error.php') ?>
	<div class="form-group">
		<label for="name">Write the name</label>
		<input name="name" id="name" class="form-control" type="text" placeholder="Default input">
		<label  for="categories">Select categories</label>
		<select multiple name="categories[]" id="categories" class="form-control">
			<? foreach($categories as $category ): ?>
				<option value="<?php echo $category['id']; ?>"><? echo $category["name"]; ?></option>
			 <? endforeach; ?>
		</select>
		<div class="form-group">
			<label for="description">Write description</label>
			<textarea class="form-control" name="description" id="description" rows="3"></textarea>
		</div>
		<button name="create" type="submit" id="button_create" class="btn btn-default" >Submit</button>
		<a href="../index.php"  class="btn btn-default"  >Cancel</a>
	</form>
	<div id="test"></div>





<html>
<head>
</head>
<body>
</body>
</html>
	<?php  require('../footer.php');?>


