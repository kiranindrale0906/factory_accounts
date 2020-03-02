$(function(){
  $("#workflows").on('change', function() {
    var workflow_id = $(this).val();
    ajax_get_request(base_url+'workflows/workflow_places?workflow_id='+workflow_id,'');
    ajax_get_request(base_url+'workflows/workflow_transitions?workflow_id='+workflow_id,'');
  });

});

function set_places_options(places) {
  set_options(places, '#places');
}

function set_transitions_options(transitions) {
  set_options(transitions, '#transitions');
}

function set_options(options, field) {
  var _field = $(field);
  _field.html('');
  if(options != undefined){
    var option_html = '';
    $.each(options, function(index, option) {
      option_html += "<option value="+option.id+">"+option.name+"</option>";
    });
    _field.append(option_html);
    _field.selectpicker('refresh');
  }
}