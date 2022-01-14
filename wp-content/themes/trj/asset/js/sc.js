<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

    $(document).ready(function() {
      $('#business').click(function(){
        $('#loan-interest').text('10%');
        $('.more').show();
      });

      $('#employee').click(function(){
        $('#loan-interest').text('5%');
        $('.more').hide();
      });

      if($('#employee').is(':checked')) {
        $('.more').hide();
      }

  $('body').on('keyup','.amount',function(e){
    if (($('#investmentPeriod').val() > 12)) {
      alert('We do not offer loans more than 12 months');
      $('#investmentPeriod').val('');
    }
    if (e.keyCode != 13) {
        var sum = 0;
        $('.amount').each(function() {
            if($(this).val() != '' && !isNaN($(this).val())){
              var investAmount = parseFloat($('#amount').val());
              var investRate = investAmount * 0.05;
              var investPeriod = parseInt($('#investmentPeriod').val());
              var investTotalAmount = investAmount / investPeriod;
              sum = investTotalAmount + investRate;
            }
        });
        if (!isNaN(sum)) {
          $('.loan-result').text('₦ ' + sum.toFixed(2));
        } else {
          $('.loan-result').text();
        } 
    }
    else{
      var sum = 0;
      $('.amount').each(function() {
        if($(this).val() != '' && !isNaN($(this).val())){
          var investAmount = parseFloat($('#amount').val());
          var investRate = investAmount * 0.05;
          var investPeriod = parseInt($('#investmentPeriod').val());
          var investTotalAmount = investAmount / investPeriod;
          sum = investTotalAmount + investRate;
        }
      });
      if (!isNaN(sum)) {
        $('.loan-result').text('₦ ' + sum.toFixed(2));
      } else {
        $('.loan-result').text();
      }
    }
  });
});
