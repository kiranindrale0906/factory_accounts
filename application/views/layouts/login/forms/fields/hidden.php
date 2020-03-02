<?php
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>
<input type="hidden"
  value="<?= $data['value']; ?>"
  name="<?= $data['name']; ?>"  
  id="<?= @$data['id']; ?>"  
  <?= $data['readonly'] ?> >