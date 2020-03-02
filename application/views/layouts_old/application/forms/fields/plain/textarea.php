<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name);  
?>
<textarea
  rows="5"        
  class="ckeditor_js <?= $data['class'] ?>"
  <?= $data['autofocus'] ?>
  placeholder="<?= $data['placeholder'] ?>"
  name="<?= $data['name']; ?>" id="<?= $data['field'] ?>" ><?= $data['value']; ?>
 </textarea>