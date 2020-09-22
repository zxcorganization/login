











<!-- require('configuration/db-connection.php'); 
$search=$_POST['search'];
$sql="select * from products "; 
if($search!=''){
	$sql.="where name like '%$search%' or description like '%$search%' ";
	$statement=$pdo->prepare($sql);
	$statement->execute();
	$data=$statement->fetchAll(PDO::FETCH_ASSOC);
	if(isset($data['0'])){
		$html='<table class="table table-bordered"><thead>
		<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Created at</th>
		</tr>
		</thead>';
		foreach($data as $list){
			$html.='<tr>
			<td>'.$list['name'].'</td>
			<td>'.$list['description'].'</td>
			<td>'.$list['created_at'].'</td>
			</tr>';
		}	
		$html.='</table>';
		echo $html;	
	}

}else{
	echo "Data not found";
} -->
