function checkedShowsection(){
  $('input.hideshow_js').on('change', function(){
    var attrid = $(this).attr('id');
    let thistrue = $(this).prop('checked');
    let thisid = thistrue==true ? attrid : false;
    // console.log(thisid);
    $("[class^='show_']").hide();
    $(".show_"+thisid+"_js").show();

    $("[class^='hide']").show();
    $(".hide_"+thisid+"_js").hide();
  });
  //for hide show section add class hideshow_js in input and id between show_ and _js  --------show_inputid_js ------

  //default
  $('input.hideshow_js').each(function(){
    var attrid = $(this).attr('id');
    let thistrue = $(this).prop('checked');
    let thisid = thistrue==true ? attrid : false;
    $("[class^='show_']").hide();
    setTimeout(function() {
      console.log(attrid);
      $(".show_"+thisid+"_js").show();
      $(".hide_"+thisid+"_js").hide();
    }, 100);
  });
}