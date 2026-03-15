<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>
<?php
if ($data['value'] != '') {
    $myDateTime = DateTime::createFromFormat('Y-m-d', $data['value']);   
}
?>

<div class="input_icon hover_icon hover_blue">
  <input  
    <?php load_field('plain/commonattr', array('data' => $data)); ?>   
    />  
    <span class="input-group-addon"><i class="fal fa-clock icon light_gray"></i></span>
</div>
<?php load_field('plain/field_error', array('data' => $data)); ?>