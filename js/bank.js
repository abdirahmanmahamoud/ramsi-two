$('#add').click(function(){
    $('#modal').modal('show');
    $('#formData')[0].reset();
})
$('#formData').submit(function(e){
    e.preventDefault();
    $('.alertInfo').html('');
    let sendData = {
        'amount' : $('#amount').val(),
        'type' : $('#type').val(),
        'description' : $('#description').val(),
        'action' : 'registerBank'
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
        'action' : 'loadDataBank'
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
                     tr += `<td class = 'seTr'><a href="../design/bankS.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
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