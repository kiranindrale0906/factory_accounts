<tr class="table_prchase_voucher_<?= $index ?>">
  <td>
    <?php load_field('plain/dropdown', array('field' => 'category',
                                             'option' => get_account_name_for_metal_issue(),
                                             'controller' => 'purchase_vouchers',
                                             'index' => $index,
                                             'is_table'=>TRUE)); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'gross_weight',
                                         'controller' => 'purchase_vouchers',
                                         'onkeyup' => 'calculate_factory_purity('.$index.')',
                                         'class' => 'issue_gross_weight',
                                         'id' => 'gross_weight_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'moti_weight',
                                         'controller' => 'purchase_vouchers',
                                         'onkeyup'=> 'calculate_factory_purity('.$index.')',
                                         'id' => 'moti_weight'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
   <td>
    <?php load_field('plain/text', array('field' => 'net_weight',
                                         'controller' => 'purchase_vouchers',
                                         'id' => 'net_weight_'.$index,
                                         'readonly' => true,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'melting',
                                         'controller' => 'purchase_vouchers',
                                         'id' => 'melting_'.$index,
                                         'readonly' => true,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'wastage',
                                         'controller' => 'purchase_vouchers',
                                         'id' => 'wastage_'.$index,
                                         'readonly' => true,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'other',
                                         'controller' => 'purchase_vouchers',
                                         'id' => 'other_'.$index,
                                         'readonly' => true,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td><td>
    <?php load_field('plain/text', array('field' => 'narration',
                                         'controller' => 'purchase_vouchers',
                                         'id' => 'narration_'.$index,
                                         'readonly' => true,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_purchase__voucher('.$index.')',
                    array(
                     'controller' => 'purchase_vouchers',
                     'index' => $index)); ?>
  </td>

</tr>