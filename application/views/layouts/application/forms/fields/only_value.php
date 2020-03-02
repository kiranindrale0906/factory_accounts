<?php 
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>

<div class="<?= $data['col']; ?>">
  <div class="form-group <?=@$data['form_group_class'] ?>">
    <?php if(isset($data['horizontal']) && $data['horizontal']!=''){?>
      <div class="<?=@$data['field_col'] ?>">
    <?php }?>   
    <p>
      <?= empty($data['value']) ? "-" : $data['value']; ?>
    </p>
    <?php if(isset($data['horizontal']) && $data['horizontal']!=''){?>
      </div>
    <?php }?> 
  </div>
</div>