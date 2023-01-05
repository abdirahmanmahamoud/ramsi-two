let  id_Transaction = $('#id_Transaction').val();
loadDataAmount(id_Transaction);

function loadDataAmount(id){
    $('#htmlData').html('');
    let send ={
       'action' :  'loadDataAmount',
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
          if(per[0].type == 'Outgoing'){
            let html = `
            <div class="row p-3">
                <div class="col-sm-2  py-1">Amount</div>
                <div class="col-sm-9 py-1">${per[0].Amount}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Type</div>
                <div class="col-sm-9 py-1">${per[0].type}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Date</div>
                <div class="col-sm-9 py-1">${per[0].date}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Purpose</div>
                <div class="col-sm-9 py-1">${per[0].Purpose}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Expected</div>
                <div class="col-sm-9 py-1">${per[0].Expected}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Note</div>
                <div class="col-sm-9 py-1">${per[0].Notes}</div>
            </div>
            `;
            $('#htmlData').append(html);
            $('#Amount').val(per[0].Amount);
            $('#Purpose').val(per[0].Purpose);
            $('#Expected').val(per[0].Expected);
            $('#Notes').val(per[0].Notes);
          }else{
            let html = `
            <div class="row p-3">
                <div class="col-sm-2  py-1">Amount</div>
                <div class="col-sm-9 py-1">${per[0].Amount}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Type</div>
                <div class="col-sm-9 py-1">${per[0].type}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Date</div>
                <div class="col-sm-9 py-1">${per[0].date}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Purpose</div>
                <div class="col-sm-9 py-1">${per[0].Purpose}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Method</div>
                <div class="col-sm-9 py-1">${per[0].Method}</div>
            </div>
            <div class="row p-3">
                <div class="col-sm-2  py-1">Note</div>
                <div class="col-sm-9 py-1">${per[0].Notes}</div>
            </div>
            `;
            $('#htmlData').append(html);
            $('#Amount').val(per[0].Amount);
            $('#Purpose').val(per[0].Purpose);
            $('#Method').val(per[0].Method);
            $('#Notes').val(per[0].Notes);
          }
        },
        error : function(data){
           console.log(data);
        },
    })
}

$('#formIncoming').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let data = {
        'action' : 'update',
        'id_Transaction' : id_Transaction,
        'type' : 'Incoming',
        'Amount' : $('#Amount').val(),
        'Purpose' : $('#Purpose').val(),
        'Method' : $('#Method').val(),
        'Notes' : $('#Notes').val(),
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
           alertInfo(data.status,data.data,'formIncoming');
         },
         error : function(data){
            console.log(data);
         },
     })
  
})
$('#formOutgoing').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let data = {
        'action' : 'update',
        'id_Transaction' : id_Transaction,
        'type' : 'Outgoing',
        'Amount' : $('#Amount').val(),
        'Purpose' : $('#Purpose').val(),
        'Expected' : $('#Expected').val(),
        'Notes' : $('#Notes').val(),
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
           alertInfo(data.status,data.data,'formOutgoing');
         },
         error : function(data){
            console.log(data);
         },
     })
})

function deleteTransaction(id_Transaction){
    let send ={
        'action' :  'deleteTransactionAmount',
        'id_Transaction' :  id_Transaction,
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
            window.location.href = '../design/customer.php';
           }
         },
         error : function(data){
            console.log(data);
         },
     })
}

$('#deleteBtn').click(function(){
    if(confirm('Im not sure')){
        deleteTransaction(id_Transaction);
    }   
})

function alertInfo(status,message,from){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
        $('#modal').modal('hide');
        $(`#${from}`)[0].reset();
        $('.alertInfo').html('');
        loadDataAmount(id_Transaction);
    }
    
}

$('#updateBnt').click(function(){
$('#modal').modal('show');
})
$('#closeX').click(function(){
$('#modal').modal('hide');
})
$('#close').click(function(){
$('#modal').modal('hide');
})