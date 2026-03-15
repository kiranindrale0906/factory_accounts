// $('.ajax').on('click', function(){
//   $(document).ajaxStart(function(){
//     $('.onclick_ajaxloader_js').show();
//   });
// });
// $(document).ajaxStop(function(){
//   $('.onclick_ajaxloader_js').hide();
// });

$(document).ajaxStop(function(){
  $('.onclick_ajaxloader_js').hide();
});
// $( document ).ajaxError(function() {
//   console.log("Somthing went wrong")
// });
// $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
//   $('.onclick_ajaxloader_js').hide();
//   swal("Oh noes!", "The AJAX request failed! "+thrownError+"", "error");
// });

// $( document ).ajaxSuccess(function( event, xhr, settings ) {  
//   console.log(settings.url);  
// });

/* -------------- Ajax Loader -------------*/
$("body").on("click", ".slide_menu_left_js", function(){
  $(".overlaybg_js").fadeToggle(300);
  $(".header_main_menu_js").toggleClass("open");
});
$("body").on("click", ".overlaybg_js", function(){
  $(this).fadeOut(300);
  $(".header_main_menu_js").removeClass("open");
});
// Add the following code if you want the name of the file appear on select
$("body").on("change", '.custom-file-input', function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});  