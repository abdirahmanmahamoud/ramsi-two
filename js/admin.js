function loadData(){
    $('#table tbody').html('');
    let data = {
        'action' : 'loadDataUser'
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
                        tr += `<td><a href="../design/adminInfo.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
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
