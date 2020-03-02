<?php 
  if (isset($data['data']))
    $data = $data['data'];
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
  $mul_arr = '';
  if($data['multiple']!='') { 
    $mul_arr = '[]'; 
  }
?>
<select 
  data-live-search="<?= $data['livesearch'] ?>"
  name="<?= $data['name']; ?><?= $mul_arr;?>" 
  id="<?= @$data['id'] ?>" 
  class="selectpicker_js <?=$data['class']?>"
  onchange="<?= $data['onchange'] ?>"
  data-width="<?=$data['data_width']?>"
  data-style="<?=$data['datastyle']?> <?=$data['disabled'] ?>" 
  data-container="body"
  data-size="6"
  title="<?= $data['placeholder']; ?>"
  <?=$data['multiple']?>
  <?= (isset($data['onchange']))?'onchange ='.$data['onchange'] :''?>>
  <?php if(!empty($data['option'])){ ?>
  <?php foreach ($data['option'] as $op): 
    if (!empty($op['selected']) || $data['value'] == $op['id']) :
      $selected = true;
    endif; ?>
      <option data-subtext="<?= isset($op['role_name']) ? $op['role_name']:'' ?>" 
        <?= (@$selected) ? 'selected="selected"' : '' ?> 
        <?= ($data['value'] == $op['id']) ? 'selected="selected"' : '' ?> 
              value="<?= $op['id'] ?>"><?= $op['name'] ?>
      </option> 
  <?php  unset($selected);  endforeach; ?>
  <?php }else{ ?> 
    <option value="" disabled>No Records Found</option>
  <?php } ?>
</select>

<?php load_field('plain/field_error', array('data' => $data)); ?>