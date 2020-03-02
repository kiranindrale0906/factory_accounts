function dragAndDrop(){
  $(".selectDeselect").click(function(){
    $(".add_column_checkbox").prop('checked', $(this).prop('checked'));
  });
 
  $(".selectDeselect").change(function(){
    if (!$(this).prop("checked")){
      $(".add_column_checkbox").prop("checked",false);
    }
  });

// FOR ARRANGE COLUMN(S)
  $( "#arrange_column_body").sortable();
  $( "#arrange_column_body").disableSelection();

};


function initialize_list_function(){
  var found_class = $('.load_list');
    found_class.ready(function(){
      found_class.each(function(){
        var url = $(this).attr('data-url');
        var show_class = $(this).attr('data-show');
        ajax_list_get(url,show_class);
      });
  });
}

function sorting(url,show_class){
  ajax_list_get(url,show_class);
}

function initialize_select_column_arrange_column(){
  $('.select_column_arrange_column').click(function(e){
    e.preventDefault();
    var form = $(this).closest('form');
    var formData = new FormData(form[0]);
    var url = form.attr('action');
    var show_class = $(this).attr('data-controller');
    $.ajax({
      type:'POST',
      url:url+'&table=1&get_html=1',
      data: formData,
      cache: false,
      processData: false,
      contentType: false,
      dataType:'Json',
      success:function(res){
        $("#ajax-modal").modal('hide');
        $('.show_'+show_class).html(res.html);
      } 
    });
  });
}

function initialize_pagination(){
  $('.pagination_set').click(function(e){
    e.preventDefault();
    var show_class = $(this).attr('data-controller');
    var url = $(this).attr('href')+'&get_html=1';
    ajax_list_get(url,show_class)
  })  
}

function ajax_list_get(url,show_class){
   $.ajax({
    'url':url,
    'type':'GET',
    'dataType':'json',
    success:function(res){
      var split = show_class.split('_');
      if(split[0] == 'show'){
        $('.'+show_class).html(res.html);
      }else{
        $('.show_'+show_class).html(res.html);
      }
    } 
  });
}

function show_all_data(url,event){
  if (event.checked){
    var href = url+'/index?show_all=1';
  }else{
    var href = url+'/index';
  }
  window.location = href;
}