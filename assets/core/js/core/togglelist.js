/* -------------- list items hide show --------------*/
function toggleList(){
  $('body .toggleList_js').each(function(){
    var thislist = $(this);
    var swcnt = thislist.attr('show');
    var thischild = $(thislist).children().nextUntil('.togglearrow_js').length;  
    $(thislist).children('.cardlist:nth-child('+swcnt+')').nextUntil('.togglearrow_js').removeClass('d-flex').addClass('d-none');
    var thisbtn = $(thislist).find('.togglearrow_js');
    $(thisbtn).on('click', function(){
      $(thislist).children('.cardlist:nth-child('+swcnt+')').nextUntil('.togglearrow_js').toggleClass('d-flex').toggleClass('d-none');
    });
    // console.log(swcnt)
    if (thischild<swcnt) {
      $(thisbtn).hide().prev().css("padding-bottom", 0);
    }
  });  
}