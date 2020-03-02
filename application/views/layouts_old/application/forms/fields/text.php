<?php
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>

<?php if(isset($data['grid']) && $data['grid']!=''){?>
  <div class="<?= $data['grid'] ?>">
<?php }?>

  <div class="form-group <?=@$data['form_group_class'] ?>"> 
    <?php load_field('plain/field_label', array('data' => $data, 'class' => @$data['label_class'])); ?>
    <?php if(isset($data['horizontal']) && $data['horizontal']!=''){?>
      <div class="<?=@$data['field_grid'] ?>">
    <?php }?>	  
      <?php load_field('plain/text', array('data' => $data)); ?>
      <?php load_field('plain/field_error', array('data' => $data)); ?>
    <?php if(isset($data['horizontal']) && $data['horizontal']!=''){?>
    </div>
    <?php }?> 
  </div>

<?php if(isset($data['grid']) && $data['grid']!=''){?>
  </div>
<?php }?>