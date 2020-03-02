<?php 
  if (isset($data['data']))
  $data = $data['data'];
  $data = get_field_data($data, $this->router, $record);
  //print_r($data); die();
?>
<div class="input_icon hover_icon hover_blue w-100">
  <input  
    type="number"
    <?php load_field('plain/commonattr', array('data' => $data)); ?>   
    <?php if($data['readonlyinput'] == 1){echo 'readonly';}?>
    />  
</div>
<?php load_field('plain/field_error', array('data' => $data)); ?>