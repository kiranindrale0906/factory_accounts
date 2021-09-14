<tr class="table_empty_packet_details_<?= $index ?>">
  <td>
     <?php load_field('plain/dropdown', array('field' => 'weight',
                                         'controller' => 'empty_packet_details',
                                         'class' => 'empty_packet_weight',
                                         'id' => 'empty_packet_weight_'.$index,
                                         'index' => $index,
                                         'option'=>$empty_packet_weights,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/dropdown', array('field' => 'quantity',
                                         'controller' => 'empty_packet_details',
                                         'class' => 'empty_packet_quantity',
                                         'id' => 'empty_packet_quantity_'.$index,
                                         'index' => $index,
                                         'option'=>$empty_packet_quantities,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_empty_packet_details('.$index.')',
                    array(
                     'controller' => 'chitti_empty_packet_details',
                     'index' => $index)); ?>
  </td>

</tr>
