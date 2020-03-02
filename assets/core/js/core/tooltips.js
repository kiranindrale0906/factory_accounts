function default_tooltip(){
  $('[data-toggle="tooltip"]').tooltip();
}

function create_tooltip() {
  $('.tooltip_js').not('.notooltip, .cke_button').tooltip({
    trigger : 'hover',
    title : function() { return get_tooltip_description(this); }
  });
}

function get_tooltip_description(obj) {
  var tooltip_heading = $(obj).attr("data-tooltip-heading");
  if (tooltip_heading==undefined) {
    tooltip_heading = $(obj).text().trim();
  }
  tooltipText = tooltip_heading.toLowerCase();
  return tooltips[tooltipText];
}

if ($(window).width()>=768) {
  $(document).ready(function() {
    create_tooltip();
  });

  $(document).ajaxStop(function() {
    create_tooltip();
  });
}



function tooltip_action(id, action,page_title){
    if (action == 'create') {
      var title_name = $('.tooltip_new_row_js .tooltip_titlenew').attr('name');
      var title_value = $('.tooltip_new_row_js .tooltip_titlenew').val();
      var text_name = $('.tooltip_new_row_js .tooltip_namenew').attr('name');  
      var text_value = $('.tooltip_new_row_js .tooltip_namenew').val();

      var post_data = {'tooltips[tooltip_heading]':title_value, 'tooltips[tooltip_hovertext]':text_value, 'tooltips[tooltip_pagetitle]':page_title}
      var action_url=base_url+'tooltips/tooltips/store';
    }else if(action == 'update' || action == 'edit' ){
      var title_name = $('#'+id).attr('name');
      var title_value = $('#'+id).val();
      var text_name = $('#'+id).attr('name');  
      var text_value = $('#'+id).val();
      var post_data = {'tooltips[tooltip_heading]':title_value, 'tooltips[tooltip_hovertext]':text_value, 'tooltips[tooltip_pagetitle]':page_title,'tooltips[id]':id};
      var action_url=base_url+'tooltips/tooltips/update/'+id;
    }else{
      var action_url=base_url+'tooltips/tooltips/delete/'+id;
      var post_data ='';
    }
    if(text_value != '' && title_value!= ''  || action=='delete'){
    $.ajax({
      url:action_url,
      type: 'post',
      data: post_data,
      dataType:'json',
      success : function(response){
        if(action=='delete'){
          $(".row_id_"+id).remove();
        }
        if (action=='create') {
          $('.tooltip_new_row_js .tooltip_titlenew').attr('value', title_value)
          $('.tooltip_new_row_js .tooltip_namenew').attr('value', text_value)
          var inputrow = $('.tooltip_new_row_js').html();
          $('.tooltip_new_row_js input').val('')
          $('.tooltip_new_row_js').before(inputrow);
              
        }
      },
      error:function(response){
        console.log(response)
      }
    });
    
    }else{
    toastr["error"]('Please fill all the fields to continue.');
  }
}