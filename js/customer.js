$('#add').click(function(){
    $('#modal').modal('show');
    $('#formData')[0].reset();
})
$('#export').on('click', function() {
    let dateTime = new Date();
    let NowDate = dateTime.getDate();
    let NowMonthNub = dateTime.getMonth();
    let NowYear = dateTime.getFullYear();
    let NowDateExport = `${NowDate}/${NowMonthNub +1}/${NowYear}`;
    let file = new Blob([$('#export-table').html()], {type:"application/vnd.ms-excel"});
    let url = URL.createObjectURL(file);
    let a = $("<a />", {
      href: url,
      download: `${NowDateExport}.xls`}).appendTo("body").get(0).click();
});
$('#formData').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let form_data = new FormData($('#formData')[0]);
      form_data.append('action','register');
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customer.php',
        data :  form_data,
        processData : false,
        contentType : false,
        success : function(data){
           alertInfo(data.status,data.data);
         },
         error : function(data){
            console.log(data);
         },
     })
})

function loadData(){
    $('#table tbody').html('');
    $('#tableExport tbody').html('');
    let data = {
        'action' : 'loadData'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customer.php',
        data :  data,
        success : function(data){
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';
            let trExport = '';

            if(status){
                response.forEach(item =>{
                   tr += '<tr>';
                   trExport += '<tr>';
                   for(let i in item){
                    if(i == 'id'){
                    }else{
                        tr += `<td><a href="../design/customers.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
                        trExport += `<td>${item[i]}</td>`;
                    }
                   }
                  
                })
                $('#table tbody').append(tr);
                $('#tableExport tbody').append(trExport);
             }
         },
         error : function(data){    
            console.log(data);
         },
     })
}
loadData();

function fethCustomerInfo(id){
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
            $('#fullName').val(per[0].fullName);
            $('#phone').val(per[0].phone);
            $('#id').val(per[0].id);
            $('#modal').modal('show');
          }
        },
        error : function(data){
           console.log(data);
        },
    })
}

$("#search").keyup(function(){
    let search = $('#search').val();
    $('#table tbody').html('');
    let data = {
        'search' : search,
        'action' : 'searchCustomer'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customer.php',
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
                        tr += `<td><a href="../design/customers.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
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
});


function alertInfo(status,message){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
        $('#modal').modal('hide');
        $('#formData')[0].reset();
        $('.alertInfo').html('');
        loadData();
    }
    
}
$('#close').click(function(){
    $('#modal').modal('hide');
    $('#formData')[0].reset();
    let btn = 'insert';
})
$('#closeX').click(function(){
    $('#modal').modal('hide');
    $('#formData')[0].reset();
    let btn = 'insert';
})


