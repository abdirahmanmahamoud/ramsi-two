let customerId = $('#customerId').val();

function loadData(customerId){
    $('#table tbody').html('');
    $('#totals').html('');
    let data = {
        'action' : 'groupIN',
        'group_id' : customerId
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
                  
                })
                let to = `Total $${data.groupBalance}`;
                $('#table tbody').append(tr);
                $('#totals').append(to);
             }
         },
         error : function(data){
            console.log(data);
         },
     })
}
loadData(customerId);
loadDataFrom(customerId);

$('#updateBnt').click(function(){
    $('#modal').modal('show');
})

function loadDataFrom(customerId){
    $('#table tbody').html('');
    let data = {
        'action' : 'groupFrom',
        'group_id' : customerId
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
            function nameInput(name){
                if(name == 'name'){
                    return 'namePr';
                }if(name == 'qty'){
                    return 'QtyPr';
                }if(name == 'price'){
                    return 'PricePr';
                }if(name == 'id'){
                    return 'idPro';
                }
            }
            function hideId(id){
                if(id == 'id'){
                    return 'd-none';
                }else{ return ''; }
            }
            if(status){
                response.forEach(item =>{
                    html += `<div class="mb-3"></div>
                    <h5 class="mb-2">product #</h5>`;
                   for(let i in item){
                    if(i == 'date'){}else{
                        html += ` 
                        <div class="mb-3 ${hideId(i)}">
                          <label class="form-label">${i}</label>
                          <input type="text" name="${nameInput(i)}" id="${nameInput(i)}" class='form-control' value="${item[i]}" required>
                        </div>
                       `
                    }
                   
                   }
                  
                })
                $('.fromhtml').append(html);
             }
         },
         error : function(data){
            console.log(data);
         },
     })
}
$('#formData').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let names =[];
    let Qtys =[];
    let Prices =[];
    let ids =[];
    let name = document.querySelectorAll('#namePr');
    let Qty = document.querySelectorAll('#QtyPr');
    let Price = document.querySelectorAll('#PricePr');
    let id = document.querySelectorAll('#idPro');
    name.forEach(input_name =>{
        names.push(input_name.value);
    })
    Qty.forEach(input_Qty =>{
        Qtys.push(input_Qty.value);
    })
    Price.forEach(input_Price =>{
        Prices.push(input_Price.value);
    })
    id.forEach(input_id =>{
        ids.push(input_id.value);
    })
    let data = {
        'names' : names,
        'qtys' : Qtys,
        'id' : ids,
        'prices' : Prices,
        'action' : 'update'
    };

    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
           alertInfo(data.status,data.data,'modal','formData');
         },
         error : function(data){
            console.log(data);
         },
     })
})

function deleteFunction(customerId){
    let send ={
        'action' :  'delete',
        'id' :  customerId,
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
            alert(per);
            window.location.href = `../design/customer.php?id=${data.id}`;
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

function alertInfo(status,message,modal,form){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
        $(`#${modal}`).modal('hide');
        $(`#${form}`)[0].reset();
        $('.alertInfo').html('');
        loadData(customerId);
        loadDataFrom(customerId);
        if(form === 'formData'){
            $('.fromhtml').html('');
        }
    }
}