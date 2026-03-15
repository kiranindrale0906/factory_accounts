function set_state_options_on_change_of_country_id() {
  $("select[name*='country_id']").on('change', function() {
    var country_id = $("[name*='country_id']").val();
    var formData = {country_id:$("[name*='country_id']").val()}
    ajax_get_request(base_url+'tutorials/states?country_id='+country_id,'',formData)
  });
}

function set_state_options(states) {
  populate_state_options(states);
}

function populate_state_options(states) {
  $("select[name*='state_id'] option").remove();
  if(states != undefined){
    $.each(states.states, function(states, country_id_field) {
      var option_html = "<option value="+country_id_field.id+">"+country_id_field.name+"</option>";
      $("select[name*='state_id']").append(option_html); 
    });
    $("select[name*='state_id']").selectpicker('refresh');
  }
}

function set_city_options_on_change_of_state_id() {
  $("select[name*='state_id']").on('change', function() {
    var state_id = $("[name*='state_id']").val();
    var formData = {state_id:$("[name*='state_id']").val()}
    ajax_get_request(base_url+'tutorials/cities?state_id='+state_id,'',formData)
  });
}

function set_city_options(cities) {
  populate_city_options(cities);
}

function populate_city_options(cities) {
  $("select[name*='city_id'] option").remove();
  if(cities != undefined){
    $.each(cities.cities, function(cities, state_id_field) {
      var option_html = "<option value="+state_id_field.id+">"+state_id_field.name+"</option>";
      $("select[name*='city_id']").append(option_html); 
    });
    $("select[name*='city_id']").selectpicker('refresh');
  }
}
