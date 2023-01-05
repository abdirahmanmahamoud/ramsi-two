let  customerId = $('#customerId').val();
fethCustomerInfo(customerId);

function fethCustomerInfo(id){
    $('#customerName').html('');
    $('#customerPhone').html(''); 
    $('#customerBalance').html('');
    $('#fullName').html('');
    $('#phone').html('');
    $('#id').html('');
    let send ={
       'action' :  'fethCustomerInfo',
       'id' :  id,
    }
    $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/customer.php',
       data :  send,
       success : function(data){
          let status = data.status;
          let per = data.data;
          let html ='';
          let tr = '';
          if(status){
             $('#customerName').append(per[0].fullName);
             $('#customerPhone').append(per[0].phone);
             $('#customerBalance').append(per[0].Balance);
             $('#fullName').val(per[0].fullName);
             $('#phone').val(per[0].phone);
             $('#id').val(per[0].id);
          }
        },
        error : function(data){
           console.log(data);
        },
    })
}

$('#fromUpdateCustomer').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let form_data = new FormData($('#fromUpdateCustomer')[0]);
      form_data.append('action','update');
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customer.php',
        data :  form_data,
        processData : false,
        contentType : false,
        success : function(data){
           alertInfo(data.status,data.data,'modal','fromUpdateCustomer');
         },
         error : function(data){
            console.log(data);
         },
     })
})
$('#fromOutgoing').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let names =[];
    let Qtys =[];
    let Prices =[];
    let name = document.querySelectorAll('#namePr');
    let Qty = document.querySelectorAll('#QtyPr');
    let Price = document.querySelectorAll('#PricePr');
    name.forEach(input_name =>{
        names.push(input_name.value);
    })
    Qty.forEach(input_Qty =>{
        Qtys.push(input_Qty.value);
    })
    Price.forEach(input_Price =>{
        Prices.push(input_Price.value);
    })
    let data = {
        'names' : names,
        'qtys' : Qtys,
        'prices' : Prices,
        'customer_id' : customerId,
        'action' : 'registerOutgoing'
    };

    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
           alertInfo(data.status,data.data,'modalOutgoing','fromOutgoing');
         },
         error : function(data){
            console.log(data);
         },
     })
})
let btn = 'insert';
$('#fromPayment').submit(function(e){
    e.preventDefault();
    let data = '';
    if(btn == 'insert'){
        data = {
            'action' : 'registerPay',
            'customer_id' : customerId,
            'amount' : $('#Amount').val()
        }
    }else{
        data = {
            'action' : 'updatePay',
            'customer_id' : customerId,
            'amount' : $('#Amount').val(),
            'id' : $('#idPay').val(),
        }
    }
    
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
           alertInfo(data.status,data.data,'modalPayment','fromPayment');
         },
         error : function(data){
            console.log(data);
         },
     })
})
function loadData(customerId){
    $('#table tbody').html('');
    let data = {
        'action' : 'loadData',
        'customerId' : customerId
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if(status){
                response.forEach(item =>{
                   tr += '<tr>';
                   for(let i in item){
                     if(i == 'id'){
                    }else{
                        tr += `<td><a href="../design/group.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
                    }
                   }
                  
                })
                $('#table tbody').append(tr);
             }
         },
         error : function(data){
            console.log(data);
         },
     })
}
loadData(customerId);
function loadDataPay(customerId){
    $('#tablePayment tbody').html('');
    let data = {
        'action' : 'loadDataPay',
        'id' : '',
        'customer_id' : customerId
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if(status){
                response.forEach(item =>{
                   tr += '<tr>';
                   for(let i in item){
                     if(i == 'id'){
                    }else{
                        tr += `<td>${item[i]}</td>`;
                    }
                   }
                   tr += `<td><a  class="btn btn-primary update_info text-white" update_id = ${item['id']}><i class="fas fa-edit"></i></a><a class=""></a> <a class="btn btn-danger delete_info text-white" delete_id = ${item['id']}><i class="fas fa-trash"></i></a></td>`;
                   tr += '</tr>';
                })
                $('#tablePayment tbody').append(tr);
             }
         },
         error : function(data){
            console.log(data);
         },
     })
}
loadDataPay(customerId);

function deleteFunction(customerId){
    let send ={
        'action' :  'deleteCustomer',
        'id' :  customerId,
     }
     $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customer.php',
        data :  send,
        success : function(data){
           let status = data.status;
           let per = data.data;
           if(per == 'not allowed to delete'){
            alert(per);
           }else{
            alert(per);
            window.location.href = '../design/';
           }
         },
         error : function(data){
            console.log(data);
         },
     })
}

$('#deleteBtn').click(function(){
    if(confirm('Im not sure')){
        deleteFunction(customerId);
    }
})

$('#updateBnt').click(function(){
    $('#modal').modal('show');
})
$('#close').click(function(){
    $('#modal').modal('hide');
})
$('#aadOutgoing').click(function(){
    $('#modalOutgoing').modal('show');
})
$('#Payment').click(function(){
    $('#modalPayment').modal('show');
    btn = 'insert';
})

$('#addFrom').click(function(){
  let html = `<div class="mb-3"></div>
  <h5 class="mb-2">product</h5>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="namePr" id="namePr" class='form-control' required>
  </div>
  <div class="mb-3">
    <label class="form-label">Qty</label>
    <input type="text" name="QtyPr" id="QtyPr" class='form-control' required>
  </div>
  <div class="mb-3">
    <label class="form-label">Price</label>
    <input type="text" name="PricePr" id="PricePr" class='form-control' required>
  </div>`;
  $('.formAdd').append(html);
})

function all(id){
    let data = {
        'action' : 'loadDataPay',
        'id' : id,
        'customer_id' : customerId
    }
    $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/customerinfo.php',
       data :  data,
       success : function(data){
          let status = data.status;
          let per = data.data;
          let html ='';
          let tr = '';
          if(status){
             $('#Amount').val(per[0].price);
             $('#idPay').val(per[0].id);
             $('#modalPayment').modal('show');
             btn = 'update';
          }
        },
        error : function(data){
           console.log(data);
        },
    })
 }

 function deletes(id){
    let send ={
        'action' :  'deletePay',
        'id' :  id,
     }
     $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  send,
        success : function(data){
           let status = data.status;
           let per = data.data;
           if(per == 'not allowed to delete'){
            alert(per);
           }else{
               loadData(customerId);
               loadDataPay(customerId);
               fethCustomerInfo(customerId);
               alert(per);
           }
         },
         error : function(data){
            console.log(data);
         },
     })
}

$('#btn-close').on('click',function(){
    $('.formAdd').html('');
    $('#fromOutgoing')[0].reset();
})
$('#btn-close-hea').on('click',function(){
    $('.formAdd').html('');
    $('#fromOutgoing')[0].reset();
})

function alertInfo(status,message,modal,form){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
        $(`#${modal}`).modal('hide');
        $(`#${form}`)[0].reset();
        $('.alertInfo').html('');
        fethCustomerInfo(customerId);
        loadData(customerId);
        loadDataPay(customerId);
        btn = 'insert';
        if(form === 'fromOutgoing'){
            $('.formAdd').html('');
        }
    }
}
$('#tablePayment').on("click",'a.update_info',function(){
    let id = $(this).attr('update_id');
    all(id);
})
$('#tablePayment').on("click",'a.delete_info',function(){
    let id = $(this).attr('delete_id');
    if(confirm('Im not sure')){
        deletes(id);
    }  
})