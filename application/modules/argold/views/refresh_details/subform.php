<tr class="table_refresh_details_<?= $index ?>">
  <td>
    <?php load_field('plain/text', array('field' => 'weight',
                                         'controller' => 'refresh_details',
                                         'class' => 'refresh_weight',
                                         'id' => 'refesh_weight_'.$index,
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
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_refresh('.$index.')',
                    array(
                     'controller' => 'refresh_details',
                     'index' => $index)); ?>
  </td>

</tr>