<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
  if ($data['value'] != '') {
    $myDateTime = date("d M, Y", strtotime($data['value']));
  }
?>
<div class="date input_icon hover_icon hover_blue">
  <input type="text"      
    <?php load_field('plain/commonattr', array('data' => $data)); ?> 
  />
  <span class="input-group-addon"><i class="fal fa-calendar-alt icon blue"></i></span>     
</div>
<?php load_field('plain/field_error', array('data' => $data)); ?>