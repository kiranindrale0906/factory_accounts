<?php 
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>

<?php if(isset($data['col']) && $data['col']!=''){?>
  <div class="<?= $data['col'] ?>">
<?php }?>

  <div class="form-group <?=@$data['form_group_class'] ?>"> 
    <?php load_field('plain/field_label', array('data' => $data, 'class' => @$data['label_col'])); ?>
    <?php if(isset($data['horizontal']) && $data['horizontal']!=''){?>
      <div class="<?=@$data['field_col'] ?>">
    <?php }?>   
      <?php load_field('plain/number', array('data' => $data)); ?>
    <?php if(isset($data['horizontal']) && $data['horizontal']!=''){?>
    </div>
    <?php }?> 
  </div>

<?php if(isset($data['col']) && $data['col']!=''){?>
  </div>
<?php }?>