$('.loss_search_date').click(function(){
    var date = $('input[name*="trial_balances[date]').val();
      var url = window.location.href;
      if (url.indexOf("?") > -1) {
        var url = url.split('?')[0];
        new_url = '?loss_date='+date;
        window.location.href = url+new_url;
      }else{
        new_url = '?loss_date='+date;
        window.location.href = url+new_url;
      }
    return true;
});

$('.profit_and_loss_search_date').click(function(){
    var from_date = $('input[name*="trial_balances[profit_and_loss_search_from_date]').val();
    var to_date = $('input[name*="trial_balances[profit_and_loss_search_to_date]').val();
    var url = window.location.href;
    var url_options = new URLSearchParams(window.location.search);
    url_options.delete('profit_and_loss_search_from_date');
    url_options.delete('profit_and_loss_search_to_date');

    if(from_date != '') {
      url_options.append('profit_and_loss_search_from_date',from_date);
    }

    if(to_date != '') {
      url_options.append('profit_and_loss_search_to_date',to_date);
    }
    if (url.indexOf("?") > -1) {
      var url = url.split('?')[0];
    }
    window.location.href = url+'?'+url_options.toString();
  return true;
});

$('.clear_btn').click(function(){
    var url = window.location.href;
    var new_url = url.split('?')[0];
    window.location.href=new_url;
});


