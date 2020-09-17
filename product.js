   let page = 1;

function onPaginationChange(eventData, pageNumber) {
  page = pageNumber;
  getProducts();
}

 function getProducts() {
  let perPage =  $('#perPageSelect').val();
  $.ajax({
   url : "product/getProducts.php?page="+page+"&perPage=" + perPage, 
   method:"POST", 
   success:function(data){
     const response = JSON.parse(data);
     const totalRows = parseInt(response.totalRows);

     let html = '';
     response.products.forEach(product => {
      html += '<tr>' +
      '<td>'+ product.id + '</td>' +
      '<td>'+ product.name + '</td>' +
      '<td>'+ product.description + '</td>' +
      '<td>'+ product.created_at + '</td>' +

      '<td><button id="'+ product.id +'" class="btn btn-warning btn-xs edit" >edit</button></td>' +
      '<td><button id="'+ product.id +'" class="btn btn-danger btn-xs delete" >remove</button></td>' +
      '</tr>';

    });
     $('#tableBody').html(html);

     if (totalRows) {
      $('#pagination').pagination({
        dataSource: new Array(totalRows),
        pageSize: perPage,
        pageNumber: page,
        afterPageOnClick: onPaginationChange,
        afterNextOnClick: onPaginationChange,
        afterPreviousOnClick: onPaginationChange 
      })
     }
   }
 });
}
 

$(document).ready(function(){
 getProducts(); 


$('#action').click(function(){
  const name = $('#name').val(); 
  const description = $('#description').val();
  const id = $('#customer_id').val();
  const category_ids = $('#category').val();

  if(name != ''){  
    if (description != '') {
      if (category_ids != '') {
       $.ajax({
        url : "product/updateProduct.php",   
        method:"POST",    
        data:{
          name:name,
          description:description,
          id:id,
          category_ids: category_ids,

        },
        success:function(data){

          $('#customerModal').modal('hide'); 
          getProducts();  
          alert('Data updated');  
        }
      });
     } else{
      alert("category is empty"); 
    }
  } else{
    alert("description is empty"); 
  }
} else{
 alert("name is empty"); 
}
});



$(document).on('click', '.edit', function(){
  const id = $(this).attr("id");
  $.ajax({
   url:"product/getProduct.php",  
   method:"GET",    
   data:{id:id},
   dataType:"json",   
   success:function(data){
     $('.modal-title').text("Update Records");
     $('#action').val("Update"); 
     $('#customer_id').val(id);  
     $('#name').val(data.name);  
     $('#description').val(data.description);
     $("#category").val(data.category_ids);

     $('#customerModal').modal('show');  
   }
 });
});

$(document).on('click', '.delete', function(){
  $(this).closest("tr").remove();
  const id = $(this).attr("id"); 
  if(confirm("Are you sure you want to remove this data?")) 
  {

   const action = "Delete"; 
   $.ajax({
    url:"product/deleteProduct.php",    
    method:"POST",     
    data:{id:id, action:action},
    success:function(data)
    {

     alert('Data Deleted');  
   }
 });
 } else {
   return false;
 }
});




})  
