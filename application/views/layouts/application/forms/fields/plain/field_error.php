<?php 
  if (isset($data['data']))
    $data = $data['data'];
  //$data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  //$data = get_field_data($data, $this->router, @$$data_variable_name); 
?>
<?php 
  $data['error'] = ((isset($data['error']) && $data['error'] == false )) ? false : true;
  if($data['error'] == true):
    if(!empty(form_error($data['name']))): ?>
      <div class="clear red font12 col-12 pl-0" id="<?= $data['name'] ?>_error">
        <?php echo form_error($data['name']); ?>
      </div>
    <?php endif;
  endif; 
?>