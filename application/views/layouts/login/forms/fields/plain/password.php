<?php 
  if (isset($data['data']))
  $data = $data['data'];
  $data = get_field_data($data, $this->router, $record);
  //print_r($data); die();
?>
<div class="w-100">
  <input  
    type="password"
    class="form-control custom_form_control"
    <?php load_field('plain/commonattr', $data); ?>
    />      
</div>