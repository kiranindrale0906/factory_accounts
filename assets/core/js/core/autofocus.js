function autofocus(){
  $('.modal.show .form-control[type="text"]:visible:eq(0)').focus().click();
  $('form input.form-control[type="text"]:visible').each(function(i){
    $(this).attr("index", i)
    $(this).addClass("index"+i);
  });
}