<tr class="table_metal_issue_voucher_<?= $index ?>">
  <td>
    <?php load_field('plain/dropdown', array('field' => 'account_name',
                                             'option' => get_account_name_for_metal_issue(),
                                             'controller' => 'metal_issue_vouchers',
                                             'index' => $index,
                                             'is_table'=>TRUE)); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'credit_weight',
                                         'controller' => 'metal_issue_vouchers',
                                         'onkeyup' => 'calculate_factory_purity('.$index.')',
                                         'class' => 'issue_credit_weight',
                                         'id' => 'credit_weight_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'factory_purity',
                                         'controller' => 'metal_issue_vouchers',
                                         'onkeyup'=> 'calculate_factory_purity('.$index.')',
                                         'id' => 'factory_purity_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
   <td>
    <?php load_field('plain/text', array('field' => 'factory_fine',
                                         'controller' => 'metal_issue_vouchers',
                                         'id' => 'factory_fine_'.$index,
                                         'readonly' => true,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_metal_issue_voucher('.$index.')',
                    array(
                     'controller' => 'metal_issue_vouchers',
                     'index' => $index)); ?>
  </td>

</tr>