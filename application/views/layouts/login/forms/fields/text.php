<?php
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name);
?>
<div class="col-12">
  <div class="form-group">       
    <?php load_field('plain/text', $data); ?>
    <?php load_field('plain/field_error', array('data' => $data)); ?>    
  </div>
</div>

