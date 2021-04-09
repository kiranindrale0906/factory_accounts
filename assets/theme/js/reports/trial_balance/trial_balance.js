$('.loss_search_date').click(function(){
    var date = $('input[name*="trial_balances[date]').val();
    alert(date);
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

$('.clear_btn').click(function(){
    var url = window.location.href;
    var new_url = url.split('?')[0];
    window.location.href=new_url;
});