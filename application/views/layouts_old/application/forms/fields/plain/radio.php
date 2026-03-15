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
  <?php  foreach ($data['option'] as $key => $op): ?>
    <?php
      if ($data['value'] != '' && $data['value'] == $op['value']) {
        $data['checked'] = 'checked';
      }
    ?>
    <div class="custom-control custom-radio btn_blue <?=@$data['input_box_class'] ?> <?=@$data['input_inline_class'] ?>">
      <input 
        type="radio"
        name="<?= $data['name'] ?>" 
        id="<?= isset($op['chk_id']) ? $op['chk_id'] : $op['label'] ?>"
        value="<?= $op['value'] ?>" 
        class="custom-control-input <?= @$data['class'] ?>"
        data-toggle="<?= @$data['toggle'] ?>"
        data-target="#<?= @$data['target'] ?>"
        <?= @$op['readonly'] ?> 
        <?= @$op['checked']; ?>
        <?= @$op['disabled'] ?>
      />
      <?php load_field('plain/checked_label', $op); ?>      
    </div>
  <?php endforeach; ?>
<?php if(empty($data['check_inline']) || !empty($data['check_inline_box'])){?>
  </div>
<?php }?>