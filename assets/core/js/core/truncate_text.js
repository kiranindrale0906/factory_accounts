/* ----------- less more  paragraph  ----------------*/
function truncate(){
  let status = 'true';
  $(".truncate_js").each(function() {
    status = $(this).attr('status');   
    if (status!='false'){
      $(this).attr('status', false)
      var ellipsestext = "...";
      var showChar = $(this).attr('show');
      var toggletype = $(this).attr('toggle-type');            
      var content = $(this).html();
      // var substrtext = $(content).text();
      substrtext = content.replace(/(<([^>]+)>)/ig,"");

      if (content.length > showChar) {
        var c = substrtext.substr(0, showChar);
        var h = content;

        if(toggletype=='btn'){
          var showhtml =   
            '<div class="truncate-text" style="display:block">' +
            c +
            '<span class="moreellipses">' +
            ellipsestext +
            '</div><div class="truncate-text" style="display:none">' +
            h +
            '</div>';
        }
        else{        
          var showhtml = '<div class="truncate-text" style="display:block">' +
          c +
          '<span class="moreellipses">' +
          ellipsestext +
          '&nbsp;&nbsp;<a href="javascript:void(0)" class="moreless more">More</a></span></span></div><div class="truncate-text" style="display:none">' +
          h +
          '<a href="" class="moreless Less">Less</a></span></div>';
        }

        var html = showhtml;
        $(this).html(html);
      }
      else{
        $(this).next(".togglearrow_js").hide();
      }
    }
  });

  if (status!='false'){
    $(".moreless").click(function() {
      var thisEl = $(this);
      var cT = thisEl.closest(".truncate-text");
      var tX = ".truncate-text";

      if (thisEl.hasClass("Less")) {
        cT.prev(tX).toggle();
        cT.slideToggle();
      } else {
        cT.toggle();
        cT.next(tX).fadeToggle();
      }
      return false;
    });          
    $('.togglearrow_js').on('click', function(){
      $(this).prev('.truncate_js').children('.truncate-text').toggle();
      $(this).toggleClass('less');
    });
  }
}