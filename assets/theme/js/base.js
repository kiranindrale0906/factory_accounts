/* ----------- Horizontal Scroll on mouse wheel  ----------------*/
$(document).ready(function() {
  // ckeditor();
  // add_ckeditor_configuration();
  checkedShowsection();
  scrollbar();
  // selectpickerHelptext();
  // ckeditorHelptext();
  // helptexteditor();
  // toggleList();
  truncate();
  //set_state_options_on_change_of_country_id();
  //set_state_options();
  //populate_state_options();
  //set_city_options_on_change_of_state_id();
  //set_city_options();
  //populate_city_options();
  //set_states();
  //set_cities();
  // colorpicker();
  autocomplete_input(); 
  ajax_on_a_tag(); 
  ajax_post_on_tag();
  initialize_list_function();
  initialize_select_column_arrange_column();
  initialize_pagination();
  ajax_post_onclick_submit();

  onload_production_summary_report();

  //permission_readonly();
  //change_list_after_update();
  // imagesvideosFancybox();
  // default_tooltip();
  autocomplete_listing();
  autocomplete_listing_selection();
}).ajaxStop(function(){
  // ckeditor();
  // add_ckeditor_configuration();
  checkedShowsection();
  // selectpickerHelptext();
  // ckeditorHelptext();  
  // helptexteditor();
 // permission_remove_popup();
  selectpicker_refresh();
  autocomplete_listing();
  ajax_on_a_tag();

  // js_example();
  // colorpicker();
  // imagesvideosFancybox();
  // default_tooltip();
  // country_code_form();  
  //save_data_with_cropper_image();
  // save_helptext();
  // autocomplete_input();
  //modalCropper();
  // autofocus();
  //change_list_inapp_status();
  initialize_select_column_arrange_column();
  initialize_pagination();
  setTimeout(function() {
   //change_count_after_update();
     //initialize_list_function();
    //toggleList();
  }, 200);
});



$(".modal").on('show.bs.modal', function(){
  dragAndDrop();
  // colorpicker();
  //save_data_with_cropper_image();
  setTimeout(function() {
    dragAndDrop();
    // autocomplete_input();
    // autofocus();
    // country_code_form();
    // formatted_phone_number();
  //save_data_with_cropper_image();
  }, 1000);
});
/* ----------- Horizontal Scroll on mouse wheel Close ----------------*/