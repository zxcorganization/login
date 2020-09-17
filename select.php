<?php 
require('configuration/db-connection.php'); 
$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll();
?>

<label  for="category">Select category</label>
<select multiple name="category" id="category" class="form-control">
<? foreach($categories as $category ): ?>
	<option  value="<?php echo $category['id']; ?>"><? echo $category["name"]; ?></option>
<? endforeach; ?>
</select>
