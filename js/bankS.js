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
    $('#amount').val('');
    $('#type').val(''); 
    $('#description').val('');
    let send ={
       'action' :  'loadDataBankId',
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
             $('#name').append(`$${per[0].amount}`);
             $('#qty').append(per[0].type);
             $('#price').append(per[0].description);
             $('#date').append(per[0].date);
             $('#amount').val(per[0].amount);
             $('#type').val(per[0].type);
             $('#description').val(per[0].description);
          }
        },
        error : function(data){
           console.log(data);
        },
    })
}

function deleteFunction(customerId){
    let send ={
        'action' :  'deleteBank',
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
            window.location.href = '../design/bank.php';
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
        'amount' : $('#amount').val(),
        'type' : $('#type').val(),
        'description' : $('#description').val(),
        'id' : customerId,
        'action' : 'updateBank'
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
    if(confirm('Are you sure to delete')){
        deleteFunction(customerId);
    }
})