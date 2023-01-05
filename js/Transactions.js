$('#fromdate').attr('disabled',true);
$('#todate').attr('disabled',true);

$('#type').on('change',function(){
    if($('#type').val() == 0){
        $('#fromdate').attr('disabled',true);
        $('#todate').attr('disabled',true);
    }else{
        $('#fromdate').attr('disabled',false);
        $('#todate').attr('disabled',false);
    }
})
$('#form').submit(function (event) {
    event.preventDefault();
    $('.table').html('');
    let fromdate = $('#fromdate').val();
    let todate = $('#todate').val();
    let data = '';
    if($('#type').val() == 0){
        data ={
            'fordate' : '',
            'todate' : '',
            'action' : 'Transactions',
          }
    }else{
        data ={
            'fordate' : fromdate,
            'todate' : todate,
            'action' : 'Transactions',
          }
    }
    $.ajax({
        method : 'POST',
        dataType : 'JSON',
        url :  '../api/customerinfo.php',
        data :  data,
        success : function(data){
           let status = data.status;
           let per = data.data;
           let table = '';
           table = `
           <thead>
           <tr>
               <th>Date</th>
               <th>Customer Name</th>
               <th>Type</th>
               <th>Amount</th>
           </tr>
       </thead>
       <tbody>
           `;
           per.forEach(item =>{
            table += '<tr>';
            for(let i in item){
                if(i == 'Purpose'){
                    table += `<td>${item [i]}`;
                }else if(i == 'Method'){
                    if(item['Method'] == 'null'){}else{
                        table += ` , ${item[i]}`;
                    }
                    table += `</td>`;
                }else{
                    table += `<td>${item [i]}</td>`;
                }
            }
            table += '</tr>';
           })
           table += '</tbody>';
           $('.table').append(table)
         },
         error : function(data){
            console.log(data);
         },
     })
})