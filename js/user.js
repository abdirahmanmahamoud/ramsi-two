$('#add').click(function(){
    $('#modal').modal('show');
    $('#from')[0].reset();
})

$('#from').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let form_data = new FormData($('#from')[0]);
      form_data.append('action','register');
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/user.php',
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
    let data = {
        'action' : 'loadData'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/user.php',
        data :  data,
        success : function(data){
            let status = data.status;
            let response = data.data;
            let tr = '';

            if(status){
                response.forEach(item =>{
                   tr += '<tr>';
                   for(let i in item){
                    if(i == 'id'){
                    }else{
                        tr += `<td><a href="../design/userinfo.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
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
loadData();

function alertInfo(status,message){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
        $('#modal').modal('hide');
        $('#from')[0].reset();
        $('.alertInfo').html('');
        loadData();
    }
    
}
$('#close').click(function(){
    $('#modal').modal('hide');
    $('#from')[0].reset();
    let btn = 'insert';
})
$('#closeX').click(function(){
    $('#modal').modal('hide');
    $('#from')[0].reset();
    let btn = 'insert';
})