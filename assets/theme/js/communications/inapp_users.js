function get_notification_list(){
  $(".count_inapp").hide();
  var page_no = $(".select_offset").attr('data-offset');
  var url = base_url+'communications/inapp_notifications/view';
  var formdata = new FormData();
  formdata.append('page_no',page_no);
  ajax_post_request(url,formdata);
}

function change_list_after_update(){ 
	$('.selectnotification').click(function(){
    var page_no = $(".select_offset").attr('data-offset');
    if(page_no == 0){
      get_notification_list();
    }
  })
  $('.morelink').click(function(){
	  get_notification_list();
  })
}

function append_list_inapp(html,new_page_no,show_next,old_page){ 
  if(old_page == 0){
    $(".show_notifications").html(html);
  }else{
    $(".more-list").append(html);
  }
  if(show_next == 0){
    $(".morelink").hide();
  }
  $(".select_offset").attr('data-offset',new_page_no);
}

function change_list_inapp_status(){ 
  $('a.updatenotification').click(function(){ 
    // e.preventDefault();
    var id = $(this).attr('id');
    var link = $(this).attr('href');
    var url = base_url+'communications/inapp_notifications/update/'+id;
    var formdata = new FormData();
    formdata.append('url',link);
    ajax_post_request(url,formdata);
    change_count_after_update();
  })
}

$('.dropdown-menu.notification_dropdown').on('click', function(event){
    event.stopPropagation();
});

function redirect_after_update(link){  
 window.open(link);
}

function change_count_after_update(){
  setTimeout(function(){  location.reload(); }, 1000);
}
