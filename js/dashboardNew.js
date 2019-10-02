$(document).ready(function(){
    let amount_budgeted = $('.amount__budgeted')
    let total = 0
    
    $(amount_budgeted).each( function(){
        total += +$(this).data('value');
        $('#total_amount_budgeted').html(`₦ ${total}`)    
    });

    $(function() {
        $('#table').bootstrapTable()
      })

      function deleteRow(r) {
        let i = r.parentNode.parentNode.rowIndex;
        document.getElementById("table").deleteRow(i);
    }
});
