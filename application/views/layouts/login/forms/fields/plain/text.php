<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>

<div class="w-100">
  <input  
    type="text"
    class="form-control custom_form_control"
    <?php load_field('plain/commonattr', $data); ?>
  />  
</div>