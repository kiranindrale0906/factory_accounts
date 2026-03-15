$('body').on('click', 'input', function(){
  $("input").removeClass("holded_input");
  $(this).addClass("holded_input");
  $('.helptext_group_js').hide();
  var thisname = $(this).attr('name');
  if (thisname!=undefined) {
    var helpid = thisname.replace(/\[/g, '_').replace(/]/g, '');
  }  
  // console.log(helpid);
  $("."+helpid+"_help_text").show();
});

// For tags
$("body").on('click', '.helptext_group_js ul>li', function(){
  var thistype = $(this).parents(".helptext_group_js").attr('type');
  if (thistype=='tags'){
    $(this).hide();
    var thisval = $(this).html();  
    $('input.holded_input').next('.tagsbox_js').prepend('<span class="tag_blue">'+thisval+'<i class="fal fa-times rm_tag_js"></i></span>');
  }
  else if(thistype=='option'){
    $('.helptext_group_js li').removeClass('active');
    $(this).addClass('active');
    var inputid = $(this).parents(".helptext_group_js").attr('id');
    var thisval = $(this).html();
    $('input.holded_input').val(thisval);
    let classindex = parseInt($('input.holded_input').attr("index"))+1;
    $("input.index"+classindex).focus().click();
  }
  else{

  }  
});

// For remove tag
$("body").on("click", ".rm_tag_js", function(){
  $(this).parent().remove();
  var thist = $(this).parent().text();
  $('.helptext_group_js ul>li:contains("'+thist+'")').show();
});



// For dropdown help text
function selectpickerHelptext(){
  $('.selectpicker_js').on('show.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    $('.helptext_group_js').hide();

    var thisname = $(this).attr('name');
    if (thisname!=undefined) {
      var helpid = thisname.replace(/\[/g, '_').replace(/]/g, '');
    }
    // console.log(helpid);

    $(".helptext_group_js."+helpid+'_help_text').show();
  });  
}


// For Ckeditor helptext
function ckeditorHelptext(){
  setTimeout(function() {
    $('body .cke_contents iframe').contents().on('click', function() {  
     $('.helptext_group_js').hide();
      var thisname = $(this).attr('title').split("Rich Text Editor, ");
      thisid = thisname[1];
      $(".helptext_group_js."+thisid+'_help_text').show();
      $('.info_div').addClass('hidden');  
    });    
  }, 1000);
}
/* -------------- Help text Close -------------*/
function helptexteditor(){
  $(".helptext_editor_js").hide();
}
$("body").on("click", ".helptext_edit_btn_js", function(){
  $(this).hide();
  $(this).siblings('.helptext_edit_btn_js').toggle(); 
  $(this).parents('.help_text_edit_js').find(".helptext_editor_js").toggle();
});



