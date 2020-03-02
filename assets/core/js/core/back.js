$(document).ready(function(){
  $('.back_page_js').on("click", function(){
    var hash = location.hash ? true : false;
    if(hash===false) {
      parent.history.back();   
    } 
  });

  $(".refresh_btn").on("click", function(){
    var loc = window.location.href,
        index = loc.indexOf('#');
    if (index > 0) {
      window.location = loc.substring(0, index);
    }
  });
});