let  userId = $('#userId').val();
fethUserInfo(userId);

function fethUserInfo(id){
    $('.user').html('');
    let send ={
       'action' :  'fethUserInfo',
       'id' :  id,
    }
    $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/user.php',
       data :  send,
       success : function(data){
          let status = data.status;
          let per = data.data;
          let html ='';
          if(status){
           html += `
           <div class="col-sm-11" style="margin-top: 20px; ">
           <div class="row" style="border: 1px solid #000; margin-left: 1px;">
           <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Full Name</div>
           <span class="col-sm-9 py-1">${per[0].fullname}</span>
           </div>
           <div class="row" style="border: 1px solid #000; margin-left: 1px;">
           <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Phone</div>
           <span class="col-sm-9 py-1">${per[0].phone}</span>
           </div>
           <div class="row" style="border: 1px solid #000; margin-left: 1px;">
           <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Status</div>
           <span class="col-sm-9 py-1">${per[0].status}</span>
           </div>
           </div>
           `;
           $('.user').append(html);
           $('#fullname').val(per[0].fullname);
           $('#phone').val(per[0].phone);
           $('#email').val(per[0].email);
           $('#status').val(per[0].status);
           $('#id').val(per[0].id);
          }

        },
        error : function(data){
           console.log(data);
        },
    })
}

$('#from').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let form_data = new FormData($('#from')[0]);
      form_data.append('action','update');
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/user.php',
        data :  form_data,
        processData : false,
        contentType : false,
        success : function(data){
           alertInfo(data.status,data.data,'modal','from');
         },
         error : function(data){
            console.log(data);
         },
     })
})

function deleteUser(userId){
    let send ={
        'action' :  'deleteUser',
        'id' :  userId,
     }
     $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/user.php',
        data :  send,
        success : function(data){
           let status = data.status;
           let per = data.data;
           alert(per);
           window.location.href = '../design/user.php';
         },
         error : function(data){
            console.log(data);
         },
     })
}

$('#passwordBtn').click(function(){
    $('#modalPass').modal('show');
})
$('#fromPassword').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let send ={
        'action' :  'updatePassword',
        'password' :  $('#passwordForm').val(),
        'id' : userId
     }  
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/user.php',
        data :  send,
        success : function(data){
           alertInfo(data.status,data.data,'modalPass','fromPassword');
         },
         error : function(data){
            console.log(data);
         },
     })
})

$('#deleteBtn').click(function(){
    if(confirm('Im not sure')){
        deleteUser(userId);
    }   
})
$('#passwordBtn').click(function(){
   $('#modalPass').modal('show'); 
})


$('#updateBnt').click(function(){
    $('#modal').modal('show');
})
$('#close').click(function(){
    $('#modal').modal('hide');
})
$('#closeX').click(function(){
    $('#modal').modal('hide');
})
function alertInfo(status,message,modal,from){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
            $(`#${modal}`).modal('hide');
            $(`#${from}`)[0].reset();
            $('.alertInfo').html('');
            fethUserInfo(userId);
    }
    
}