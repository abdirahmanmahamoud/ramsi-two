let  customerId = $('#customerId').val();
fethCustomerInfo(customerId);
$('#updateBnt').click(function(){
    $('#modal').modal('show');
})
function fethCustomerInfo(id){
    $('#name').html('');
    $('#qty').html(''); 
    $('#price').html('');
    $('#date').html('');
    $('#nameInput').val('');
    $('#qtyInput').val(''); 
    $('#priceInput').val('');
    let send ={
       'action' :  'loadDataInventoryId',
       'id' :  id,
    }
    $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/inventory.php',
       data :  send,
       success : function(data){
          let status = data.status;
          let per = data.data;
          let html ='';
          let tr = '';
          if(status){
             $('#name').append(per[0].name);
             $('#qty').append(per[0].qty);
             $('#price').append(`$${per[0].price}`);
             $('#date').append(per[0].date);
             $('#nameInput').val(per[0].name);
             $('#qtyInput').val(per[0].qty);
             $('#priceInput').val(per[0].price);
          }
        },
        error : function(data){
           console.log(data);
        },
    })
}

function deleteFunction(customerId){
    let send ={
        'action' :  'deleteInventory',
        'id' :  customerId,
     }
     $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/inventory.php',
        data :  send,
        success : function(data){
           let status = data.status;
           let per = data.data;
           if(per == 'not allowed to delete'){
            alert(per);
           }else{
            alert(per);
            window.location.href = '../design/inventory.php';
           }
         },
         error : function(data){
            console.log(data);
         },
     })
}

 $('#formData').submit(function(e){
    e.preventDefault();
    $('.alertInfo').html('');
    let sendData = {
        'name' : $('#nameInput').val(),
        'qty' : $('#qtyInput').val(),
        'price' : $('#priceInput').val(),
        'id' : customerId,
        'action' : 'updateInventory'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/inventory.php',
        data :  sendData,
        success : function(data){
           if(data.status == true){
            $('#modal').modal('hide');
            $('#formData')[0].reset();
            fethCustomerInfo(customerId);
           }
         },
         error : function(data){
            console.log(data);
         },
     })
})
$('#deleteBtn').click(function(){
    if(confirm('Im not sure')){
        deleteFunction(customerId);
    }
})