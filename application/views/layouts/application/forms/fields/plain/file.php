<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>
<div class="custom-file input_icon hover_icon hover_blue">
  <input type="file" 
  class="custom-file-input" 
  id="<?= isset($data['label_for']) ? $data['label_for'] : $data['label'] ?>"
  name="<?= $data['name'] ?>">
  <label class="custom-file-label" for="<?= isset($data['label_for']) ? $data['label_for'] : $data['label'] ?>">Choose file</label>
  <i class="far fa-paperclip icon"></i>
</div> 
<?php load_field('plain/field_error', array('data' => $data)); ?>