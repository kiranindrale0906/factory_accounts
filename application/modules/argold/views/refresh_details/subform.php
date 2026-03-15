<tr class="table_refresh_details_<?= $index ?>">
  <td>
    <?php load_field('plain/text', array('field' => 'weight',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_weight',
                                         'id' => 'refesh_weight_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'purity',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_purity',
                                         'id' => 'refresh_purity_'.$index,
                                         'onkeyup' => 'calculate_refresh_purity('.$index.')',
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  
  <td>
    <?php load_field('plain/text', array('field' => 'fine',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_fine',
                                         'id' => 'refesh_fine_'.$index,
                                         'index' => $index,
                                         'readonly'=>'readonly',
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'factory_purity',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_factory_purity',
                                         'id' => 'refresh_factory_purity_'.$index,
                                         'onkeyup' => 'calculate_refresh_factory_purity('.$index.')',
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'factory_fine',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_factory_fine',
                                         'id' => 'refesh_factory_fine_'.$index,
                                         'index' => $index,
                                         'readonly'=>'readonly',
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/dropdown', array('field' => 'item_name',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_item_name',
                                         'id' => 'refresh_item_name_'.$index,
                                         'index' => $index,
                                         'option'=>$item_names,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_refresh('.$index.')',
                    array(
                     'controller' => 'refresh_details',
                     'index' => $index)); ?>
  </td>

</tr>
<script>
  var narrations = <?= json_encode(get_records_by_id($narrations)); ?>
</script>