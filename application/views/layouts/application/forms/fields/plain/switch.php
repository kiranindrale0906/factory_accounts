<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>
<?php  foreach ($data['option'] as $op): ?>
  <?php
    $checked = false;
    if ($data['value'] != '' && $data['value'] == $op['value']) {
      $checked = true;
    }
  ?>
  <div class="custom-control custom-switch btn_blue custom_switch">
    <input
    	value="<?= $op['value']?>"
    	type="checkbox" 
    	class="custom-control-input" 
    	id="<?= isset($op['chk_id']) ? $op['chk_id'] : $op['label'] ?>"
    	name="<?= $data['name'] ?>"
      <?php if($data['readonlyinput'] == 1){echo 'readonly';}?>
      <?= @$data['checked'] ?>
      <?= @$data['disabled'] ?>
    >
    <?php load_field('plain/checked_label', $op); ?>
  </div>
<?php endforeach; ?>

<?php load_field('plain/field_error', array('data' => $data)); ?>