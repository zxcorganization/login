<?php session_start(); ?>
<?php  require('header.php');?>
<link rel="stylesheet" type="text/css" href="https://pagination.js.org/dist/2.1.5/pagination.css">
<?php require('configuration/db-connection.php'); ?>

<?php 
$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll();
?>

<script type="text/javascript" src="panigation.js"></script> 
<script type="text/javascript" src="product.js"></script> 

<link rel="stylesheet" type="text/css" href="css.css">
<?php if (isset ($_SESSION["username"])): ?>
  <div class="hello_user">
   <h3 > Login Success, Welcome  <?php echo $_SESSION["username"];  ?> </h3>

   <div class="download_logout_div">
    <a href="user/logout.php">Logout</a>
    <a class="download" href="download.php" title="ImageName">
      Download image
    </a>
  </div>
</div> 
<div class="form-group">
  <input type="text" name="search" id="search" placeholder="Search.." onkeyup="getProducts()">
</div>
<select onchange="getProducts()"
id="perPageSelect"

class="form-control"
>
<option value="5">5</option>
<option value="15">15</option>
<option value="25">25</option>
<option value="50">50</option>
</select>







<select onchange="getProducts()" id="category_id"  class="form-control">
<option value="0">All</option>
<? foreach($categories as $category ): ?>

  <option  value="<?php echo $category['id']; ?>"><? echo $category["name"]; ?></option>

<? endforeach; ?>

</select>







<div id="result"></div>
<a href="product/createproduct.php"  class="btn btn-default btn_create">Create</a>
</div>

<table  class="table">
  <tr>
    <th width="5%">id</th>
    <th width="15%">Name</th>
    <th width="20%">Description</th>
    <th width="20%">Created at</th>
    <th width="10%">Update</th>
    <th width="10%">Delete</th>
  </tr>
  <tbody id="tableBody"></tbody>
</table>
<div id="pagination"></div>

<div id="customerModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Create New Records</h4>
  </div>
  <div class="modal-body">
    <label>Enter Name</label>
    <input type="text" name="name" id="name" class="form-control" />
    <br/>
    <?php require('select.php') ?>
    <br/>
    <label>Write the description</label>
    <input type="text" name="description" id="description" class="form-control" />
    <br/>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="customer_id" id="customer_id" />
    <input type="submit" name="action" id="action" class="btn btn-success" />
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
</div>













<?php else: ?>
 <button type="button"class="btn btn-secondary btn-sm"><a style="text-decoration: none;" href="user/login.php">логин</a></button>
 <button type="button" class="btn btn-secondary btn-sm"><a style="text-decoration: none;"href="user/register.php">регистрация</a>
 </button>;  
<?php endif; ?> 
<?php  require('footer.php');?>
<script type="text/javascript">
  


</script>




