$('#add').click(function(){
    $('#modal').modal('show');
    $('#formData')[0].reset();
})
$('#formData').submit(function(e){
    e.preventDefault();
    $('.alertInfo').html('');
    let sendData = {
        'name' : $('#name').val(),
        'qty' : $('#qty').val(),
        'price' : $('#price').val(),
        'action' : 'registerInventory'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/inventory.php',
        data :  sendData,
        success : function(data){
           if(data.status == true){
            $('#modal').modal('hide');
            $('#formData')[0].reset();
            loadDataInventory();
           }
         },
         error : function(data){
            console.log(data);
         },
     })
})
loadDataInventory();
function loadDataInventory(){
    $('#table tbody').html('');
    let dataSend = {
        'action' : 'loadDataInventory'
    };
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/inventory.php',
        data :  dataSend,
        success : function(data){
            let tr = '';
            data.data.forEach(item =>{
                tr += '<tr>';
                for(let i in item){
                 if(i == 'id'){
                 }else{
                     tr += `<td class = 'seTr'><a href="../design/inventoryS.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
                 }
                }
                tr += '</tr>';
             })
             $('#table tbody').append(tr);
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
        'action' : 'searchInventory'
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/inventory.php',
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
                        tr += `<td><a href="../design/inventoryS.phpid=${item['id']}"class='aName'>${item[i]}</a></td>`;
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