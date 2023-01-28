$('#add').click(function(){
    $('#modal').modal('show');
    $('#formData')[0].reset();
})
$('#export').on('click', function() {
    let dateTime = new Date();
    let NowDate = dateTime.getDate();
    let NowMonthNub = dateTime.getMonth();
    let NowYear = dateTime.getFullYear();
    let NowDateExport = `${NowDate}/${NowMonthNub +1}/${NowYear}`;
    let file = new Blob([$('#export-table').html()], {type:"application/vnd.ms-excel"});
    let url = URL.createObjectURL(file);
    let a = $("<a />", {
      href: url,
      download: `Vendor ${NowDateExport}.xls`}).appendTo("body").get(0).click();
});
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
    $('#tableExport tbody').html('');
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
            let trExport = '';
            data.data.forEach(item =>{
                tr += '<tr>'; 
                trExport += '<tr>'; 
                for(let i in item){
                 if(i == 'id'){
                 }else{
                     tr += `<td><a href="../design/Stores.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
                     trExport += `<td>${item[i]}</td>`;
                 }
                }
               
             })
             $('#table tbody').append(tr);
             $('#tableExport tbody').append(trExport);
             $('#totals').append(`Total $${data.totalPrice}`)
             $('#totalsE').append(`Total $${data.totalPrice}`)
        },
         error : function(data){
            console.log(data);
         },
     })
}