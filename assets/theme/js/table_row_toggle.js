$(function() {
    var val = 0;
    $('.toggle_row').click(function() {
      var target_data_id = $(this).attr("data-target-id");
      $(this).toggleClass("active_row");
      if(val == 0)
      	$(this).attr("toggle-status",1);
      else{
      	$('.closed_row_'+target_data_id).removeClass("active");
      	$(this).attr("toggle-status",0);
      }
      $('.sub_toggle_id_'+target_data_id).toggleClass("active");
      val = (val == 0)?1 : 0
    });

  $(".sub_toggle_row").click(function(){
  	var get_data_target_id = $(this).attr('data-target-id');
  	$(".sub_toggle_content_"+get_data_target_id).toggleClass("active");
  });
})


