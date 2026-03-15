function onload_production_summary_report() {
  onclick_checkbox_calculate_chitti_quantity();
  onchange_of_product_name_set_process_name();
  onchange_of_in_purity_set_category_one();
  onchange_of_category_one_set_machine_size();
  onchange_of_machine_size_set_design_code();
}

function onchange_of_product_name_set_process_name() {
  $("select[name*='production_summary[product_name]']").on('change', function() {
    var product_name = $("select[name*='production_summary[product_name]']").val();
    window.location = base_url+ 'reports/production_summary/index?production_summary[product_name]='+product_name;
  });
}

function onchange_of_in_purity_set_category_one() {
  $("select[name*='production_summary[in_purity]']").on('change', function() {
    var product_name = $("select[name*='production_summary[product_name]']").val();
    var in_purity = $("select[name*='production_summary[in_purity]']").val();
    window.location = base_url+ 'reports/production_summary/index?production_summary[product_name]='+product_name+'&production_summary[in_purity]='+in_purity;
  });
}

function onchange_of_category_one_set_machine_size() {
  $("select[name*='production_summary[category_one]']").on('change', function() {
    var product_name = $("select[name*='production_summary[product_name]']").val();
    var in_purity = $("select[name*='production_summary[in_purity]']").val();
    var category_one = $("select[name*='production_summary[category_one]']").val();
    window.location = base_url+ 'reports/production_summary/index?production_summary[product_name]='+product_name+'&production_summary[in_purity]='+in_purity+'&production_summary[category_one]='+category_one;
  });
}

function onchange_of_machine_size_set_design_code() {
  $("select[name*='production_summary[machine_size]']").on('change', function() {
    var product_name = $("select[name*='production_summary[product_name]']").val();
    var in_purity = $("select[name*='production_summary[in_purity]']").val();
    var category_one = $("select[name*='production_summary[category_one]']").val();
    var machine_size = $("select[name*='production_summary[machine_size]']").val();
    window.location = base_url+ 'reports/production_summary/index?production_summary[product_name]='+product_name+'&production_summary[in_purity]='+in_purity+'&production_summary[category_one]='+category_one+'&production_summary[machine_size]='+machine_size;
  });
}
function onclick_checkbox_calculate_chitti_quantity(){
  $('.chitti_details_id').click(function(){
    calculate_chitti_fields();
  });
}

function calculate_chitti_fields(){
  // alert('hhihihihi');
  var total_quantity = 0;
  $('.chitti_details_id:checked').each(function() {
    total_quantity = total_quantity + parseFloat($(this).closest("tr").find(".quantity").text());
    });
  // alert(total_quantity);
  calculate_total_weights(total_quantity);
}

function calculate_total_weights(quantity) {
  total_quantity=0;
  if (quantity != 0) {
    total_quantity = (quantity).toFixed(1);
    }
    set_issue_department_field_value('hallmark_quantity', total_quantity);
  }
function set_issue_department_field_value(input_name, value) {
  if (isNaN(value)) { value = 0; }
    $('input[name*="chittis[' + input_name + ']"]').val(parseFloat(value).toFixed(4));  
}




