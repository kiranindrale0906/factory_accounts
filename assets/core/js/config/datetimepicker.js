$("body").on("focus", ".datepicker_js", function(){
  $(this).bootstrapMaterialDatePicker({
    switchOnClick: true,
    clearButton:true,
    time: false,
    // format : 'YYYY-MM-DD',
    format : 'DD-MM-YYYY',
    placeholder : 'DD-MM-YYYY',
    weekStart : 0
  });
});

$("body").on("focus", ".monthpicker_js", function(){
  $(this).bootstrapMaterialDatePicker({
    clearButton:true,
    time: false,
    format : 'MMM YYYY',
    weekStart : 0, 
  });
});

$("body").on("focus", ".timepicker_js", function(){
  $(this).bootstrapMaterialDatePicker({
    clearButton:true,
    date: false,
    format : 'HH:mm'
  }).on('change',function(e,val){
    id=$(this).attr('id');
    $('#'+id).val(e.target.value);
  });

});
 
$("body").on("focus", ".datepicker_prevnone_js", function(){
  $(this).bootstrapMaterialDatePicker({ 
    switchOnClick: true,
    clearButton:true,
    time: false,
    //format : 'YYYY-MM-DD',
    minDate : new Date() 
  });
});