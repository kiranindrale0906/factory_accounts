/* -------- Side menu -------------*/
const windowswidth = $(window).width();
function adminLeftMenu(){
  $(".btn_slide_sidemenu_js").on("click", function(){ 
    $("body").toggleClass("expand_sidemenu");
      var bodyclass = $("body").attr("class");
      sessionStorage.setItem("bodyclass", bodyclass);

      if ($("body").hasClass("expand_sidemenu")) {
        $(".overlaybg_js").show();
      }
      else{
        $(".overlaybg_js").hide ();
      }    
  });

$(".submenu_js").on("click", function(){
  $(".submenu_js").removeClass("open");
  $(".submenu_js").not(this).children("ul").slideUp();
  $(this).children("ul").slideToggle(300);
  $(this).toggleClass("open");
});


$(".overlaybg_js").on("click", function(){
 $("body").removeClass("expand_sidemenu");
 $(".overlaybg_js").hide();
});
}


$(document).ready(function(){
  adminLeftMenu();
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