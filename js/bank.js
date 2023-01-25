$('#add').click(function(){
    $('#modalBank').modal('show');
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
      download: `${NowDateExport}.xls`}).appendTo("body").get(0).click();
});
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
            $('#modalBank').modal('hide');
            $('#formData')[0].reset();
           }
         },
         error : function(data){
            console.log(data);
         },
     })
})
$('#fromdate').attr('disabled',true);
$('#todate').attr('disabled',true);

$('#typeSelect').on('change',function(){
    if($('#typeSelect').val() == 0){
        $('#fromdate').attr('disabled',true);
        $('#todate').attr('disabled',true);
    }else{
        $('#fromdate').attr('disabled',false);
        $('#todate').attr('disabled',false);
    }
})
$('#formDataBank').submit(function (event) {
    event.preventDefault();
    $('#table tbody').html('');
    $('#tableExport tbody').html('');
    $('#total').html('');
    let fromdate = $('#fromdate').val();
    let todate = $('#todate').val();
    let data = '';
    if($('#typeSelect').val() == 0){
        data ={
            'fordate' : '',
            'todate' : '',
            'action' : 'loadDataBank',
          }
    }else{
        data ={
            'fordate' : fromdate,
            'todate' : todate,
            'action' : 'loadDataBank',
          }
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/inventory.php',
        data :  data,
        success : function(data){
            let tr = '';
            let trExport = '';
            data.data.forEach(item =>{
                tr += '<tr>';
                trExport += '<tr>';
                for(let i in item){
                 if(i == 'id'){
                 }else{
                     tr += `<td class = 'seTr'><a href="../design/bankS.php?id=${item['id']}"class='aName'>${item[i]}</a></td>`;
                     trExport += `<td>${item[i]}</td>`;
                 }
                }
                tr += '</tr>';
             })
             let html = `<p class="fs-4 shadow bg-white rounded mt-2 mb-0 text-center" style="height: 30px;display: flex; align-content: center;justify-content: center;margin-bottom: 2px;">total $${data.total ? data.total : '0'}</p>`
             $('#table tbody').append(tr);
             $('#total').append(html);
             $('#tableExport tbody').append(trExport);
        },
         error : function(data){
            console.log(data);
         },
     })
})