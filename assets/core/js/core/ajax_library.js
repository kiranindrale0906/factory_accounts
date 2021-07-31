function ajax_get_request(url, title,data) {
  $('.onclick_ajaxloader_js').show();
  $.ajax({
    type : 'GET',
    url : url,
    data:data,
    dataType:'JSON',
    success: function(response) {
      if (response.open_modal == '1') {
        $('#core-modal .modal-body').html(response.data);
        if(response.title != 'undefined' && response.title != 'null'){
          $('.modal-title').text('');
          $('.modal-title').text(response.title);
        }
        if(title != null && title !=''){
          $('.modal-title').text(title);
        }
        modal_js('show');
      }
        
      if (response.js_function != null && response.js_function != '') {
        eval(response.js_function); 
      }
      $('.onclick_ajaxloader_js').hide();
    }
  });
};

var currentRequest = null;    
function ajax_post_request(url,formData, reqOff) {
  if (reqOff!='autocomplete') {
    $('.onclick_ajaxloader_js').show();
  }
  toastr.remove(); 
  currentRequest = $.ajax({
    type : 'POST',
    url: url,
    data: formData,
    cache: false,
    processData: false,
    contentType: false,
    dataType:'Json',
    beforeSend : function()    {           
      if(currentRequest != null) {
        currentRequest.abort();
      }
    },
    success: function(response) {
      //if (response.status == 'success') {
      //if(response.hide_modal != 0) {
      if(response.open_modal != 0) {
        modal_js('hide');
      } else {
        $('#core-modal .modal-body').html(response.data); 
      }
      
      if (response.message != null && response.message != '') {
        toastr[response.status](response.message);
      } 

      if (response.js_function != null && response.js_function != '') {
        eval(response.js_function); 
      }
      
      if(response.errors!=null && response.errors!='' && response.open_modal != 0) {
        display_errors(response.errors);
      } 

      $('.onclick_ajaxloader_js').hide();
    }

  });
};

function ajax_on_a_tag() {
  $('body').on('click', 'a.ajax', function(e) {
    $('.onclick_ajaxloader_js').show();
    e.preventDefault();
    var url = $(this).attr('href');
    var title = $(this).attr('data-title');
    ajax_get_request(url, title);
  });
}

function ajax_post_on_tag(){
  $('body').on('click', 'a.ajax_post', function(e) {
    e.preventDefault();
    var success_function = $(this).attr('success_function');
    var url = $(this).attr('href');
    var formData = JSON.parse($(this).attr('data-ajax'));
    var form = new FormData();
    $.each(formData, function(key, value) {
      form.append(key,value);
    });
    ajax_post_request(url, form)
  });
}

function ajax_post_onclick_submit(){
  $('body').on('click', 'button.ajax_post', function(e) {
    e.preventDefault();
    var url = $(this).closest('form').attr('action');
    var formData = new FormData($(this).closest('form')[0]);
    ajax_post_request(url, formData);
  });
}

function display_errors(errors) {
  $.each(errors,function(error_id,error_message) {
    var errorid=error_id.replace( /(:|\.|\[|\]|,|=|@)/g, "\\$1" );
    $("#"+errorid+"_error").text(error_message);
  });
}