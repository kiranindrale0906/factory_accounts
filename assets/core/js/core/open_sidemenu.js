/* -------- Side menu -------------*/
const windowswidth = $(window).width();
function adminLeftOpenMenu(){
  if (windowswidth>769) {
    $(".btn_slide_sidemenu_js").on("click", function(){
     $("body").toggleClass("expand_sidemenu");
      $(".sidenavbar_js").toggleClass("expand");
      var bodyclass = $("body").attr("class");
      
      if ($(".sidenavbar_js").hasClass("expand")) {      
        sessionStorage.setItem("sidenavbarStrg", "expand");
      }
      else{
        sessionStorage.setItem("sidenavbarStrg", "");
      }
      sessionStorage.setItem("bodyclass", bodyclass);
    });  
    var get_bodyclass = sessionStorage.getItem("bodyclass");
    if (get_bodyclass!==null) {
      $("body").removeClass().addClass(get_bodyclass);
    } 
    var sidenStrg = sessionStorage.getItem("sidenavbarStrg");  
    if (sidenStrg=="expand") {
      $(".sidenavbar_js").addClass("expand");
    }
    else{
     $(".sidenavbar_js").removeClass("expand"); 
    }    
  }
  else{
    $(".sidenavbar_js").removeClass("expand");
    $(".btn_slide_sidemenu_js").on("click", function(){
      $(".sidenavbar_js").toggleClass("expand");
      $(".overlaybg_js").show();
    });
    $(".overlaybg_js").on("click", function(){
      $(".sidenavbar_js").removeClass("expand");
    });
  } 
  $(".submenu_js").on("click", function(){
    $(".submenu_js").not(this).removeClass("open");
    $(".submenu_js").not(this).children("ul").slideUp();
    $(this).children("ul").slideToggle(300);
    $(this).toggleClass("open");
  }); 
}

$(document).ready(function(){
  adminLeftOpenMenu();
});

/* ---------- For Active Nav ----------- */
$(".sidenavbar_js>ul>li").removeClass("active");
$(".sidenavbar_js a").filter(function(){
  return this.href == location.href.replace(/#.*/, "");  
}).parents("li").addClass("open active");

if ($(".sidenavbar_js li").hasClass("active")) {
  $(".sidenavbar_js").addClass("expand");
} else {
  $(".sidenavbar_js").removeClass("expand")
}
/* ---------- For Active Nav ----------- */


/* -------- Side menu -------------*/