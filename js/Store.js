$('#add').click(function(){
    $('#modal').modal('show');
    $('#formData')[0].reset();
})
$('#formData').submit(function(event){
    event.preventDefault();
    let storeName = $('#storeName').val();
    let storePhone = $('#storePhone').val();
    let dataSend = {
        'storeName' : storeName,
        'storePhone' : storePhone,
        'action' : 'registerStore'
    };
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/Store.php',
        data :  dataSend,
        success : function(data){
           if(data.status == true){
                $('#storeName').val('');
                $('#storePhone').val('');
                $('#modal').modal('hide');
                loadDataStore();
           }
         },
         error : function(data){
            console.log(data);
         },
     })
})
$("#search").keyup(function(){
    let search = $('#search').val();
    $('#table tbody').html('');
    let data = {
        'search' : search,
        'action' : 'searchStore'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/Store.php',
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
                        tr += `<td><a href="../design/Stores.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
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
loadDataStore();
function loadDataStore(){
    $('#table tbody').html('');
    let dataSend = {
        'action' : 'loadDataStore'
    };
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/Store.php',
        data :  dataSend,
        success : function(data){
            let tr = '';
            data.data.forEach(item =>{
                tr += '<tr>';
                for(let i in item){
                 if(i == 'id'){
                 }else{
                     tr += `<td><a href="../design/Stores.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
                 }
                }
               
             })
             $('#table tbody').append(tr);
        },
         error : function(data){
            console.log(data);
         },
     })
}