<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>
<div class="input_icon hover_icon hover_blue w-100">
  <input type="password"
    <?php load_field('plain/commonattr', $data); ?>
    />  
    <i class="fas fa-pencil-alt icon"></i>
</div>