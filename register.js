$('#form').submit(function(e){
    e.preventDefault();
    $('.alertInfo').html('');
    let fullName = $('#fullname').val();
    let phone = $('#phone').val();
    let password = $('#password').val();
    let send ={
        'action' :  'register',
        'fullName' :  fullName,
        'phone' :  phone,
        'password' :  password
     }
     $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  'login-api.php',
        data :  send,
        success : function(data){
            alertInfo(data.status,data.data)
         },
         error : function(data){
            console.log(data);
         },
     })
})
function alertInfo(status,message){
    let alert = $('.alertInfo');
    if(status == false){
        let danger = `<div class="alert alert-danger">${message}</div>`;
        alert.append(danger);
    }else if(status == true){
        window.location.href = './';
    }
    
}