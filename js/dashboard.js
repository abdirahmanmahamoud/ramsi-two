function dashboard(){
    let send ={
       'action' :  'dashboard',
    }
    $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/dashboard.php',
       data :  send,
       success : function(data){
          let status = data.status;
          let per = data.data;
          let html ='';
          if(status){
            $('#Customers').append(per.customersNumber)
            $('#Reading').append(`$${per.outgoing}`)
            $('#Payment').append(`$${per.Incoming}`)
            $('#user').append(`$${per.bank}`)
          }

        },          
        error : function(data){
           console.log(data);
        },
    })
}
dashboard();
function Customers(){
   $('#table tbody').html('');
   let data = {
       'action' : 'Customers'
   }
   $.ajax({
       method : 'POST',
       dataType : 'JSON',
       url :  '../api/dashboard.php',
       data :  data,
       success : function(data){
           let status = data.status;
           let response = data.data;
           let tr = '';
           if(status){
               response.forEach(item =>{
                  tr += '<tr>';
                  for(let i in item){
                       tr += `<td>${item[i]}</td>`;
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
Customers();