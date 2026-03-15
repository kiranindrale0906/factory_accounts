$(function(){
  $('#trigger').change(function(){
    var _time_limit = $('#time_limit');
    var time_limit_col = _time_limit.parents('.col-md-6');
    if($(this).val() == 'TIME') {
      time_limit_col.removeClass('hidden');
    } else {
      time_limit_col.addClass('hidden');
      _time_limit.val('');
    }
  });

  var trigger_val = $('#trigger').val();
  if (trigger_val) {
    $('#trigger').trigger('change');
  }
});