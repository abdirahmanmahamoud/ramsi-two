function CompanyProfile(){
    $('.user').html('');
    let send ={
       'action' :  'loadDataUser',
    }
    $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/profile-user.php',
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
            <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Time To Expire</div>
            <span class="col-sm-9 py-1">${per[0].time_to_expire}</span>
            </div>
            </div>
           `;
           $('.user').append(html);
          }

        },
        error : function(data){
           console.log(data);
        },
    })
}
CompanyProfile();


$('#fromPassword').submit(function(event){
    event.preventDefault();
    $('.alertInfo').html('');
    let send ={
        'action' :  'updatePassword',
        'password' :  $('#passwordForm').val()
     }  
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/profile-user.php',
        data :  send,
        success : function(data){
           alertInfo(data.status,data.data,'modalPass','fromPassword');
         },
         error : function(data){
            console.log(data);
         },
     })
})
$('#passwordBtn').click(function(){
    $('#modalPass').modal('show');
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
        CompanyProfile();       
    }
    
}