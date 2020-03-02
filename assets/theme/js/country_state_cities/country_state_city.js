function set_states(){
	$("select[name*='country']").on('change', function(){
    var country_id = $(this).val();
    var state_arr = states[country_id];
    $('#state').empty();
    if(country_id!=0){
        var s = "<option>"+state_arr.name+"</option>";
        $("#state").append(s); 
      $("select[name*='state']").selectpicker('refresh');
    }
	});
}

function set_cities(){
	$("select[name*='state']").on('change', function(){
    var state_id = $(this).val();
    var city_arr = cities[state_id];
    $('#city').empty();
    if(state_id!=0){
        var c = "<option>"+city_arr.name+"</option>";
        $("#city").append(c); 
      $("select[name*='city']").selectpicker('refresh');
    }
	});
}