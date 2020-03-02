<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
  $flex_col = "flex-column";
  if(!empty($data['check_inline_box']))
    $flex_col = "";
?>
<?php if(empty($data['check_inline'])){?>
  <div class="d-flex <?=$flex_col ?>">
<?php }?>

  <?php  foreach ($data['option'] as $op): ?>
    <?php
     $do_checked = '';
      if ($data['value'] != '' && $data['value'] == $op['value']) {
         $do_checked = 'checked';
      }
      else{
        if ($data['value'] == '' && empty($data['value'])) {          
          $do_checked = @$op['checked']; 
        }
      }
  ?>
  
  <div class="custom-control custom-checkbox btn_blue <?=@$data['input_box_class'] ?> <?=@$data['input_inline_class'] ?>">
      <input  
        type="checkbox"
        name="<?= $data['name'] ?>" 
        id="<?= isset($op['chk_id']) ? $op['chk_id'] : $op['label'] ?>"
        value="<?= $op['value'] ?>" 
        class="custom-control-input <?= @$data['class'] ?>"
        data-toggle="<?= @$data['data-toggle'] ?>"
        data-target="#<?= @$data['data-target'] ?>"
        <?= @$op['readonly'] ?> 
        <?=$do_checked?>
        <?= @$op['disabled'] ?>
      />
      <?php load_field('plain/checked_label', $op); ?>
    </div>
  <?php endforeach; ?>
<?php if(empty($data['check_inline']) || !empty($data['check_inline_box'])){?>
  </div>
<?php }?>    
<?php load_field('plain/field_error', array('data' => $data)); ?>