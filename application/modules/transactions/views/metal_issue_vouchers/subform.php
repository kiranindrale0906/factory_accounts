<tr class="table_metal_issue_voucher_<?= $index ?>">
  <td>
    <?php load_field('hidden', array('field' => 'id',
                                     'index' => $index,
                                     'controller' => 'metal_issue_vouchers')); ?>

  </td>
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
                                         'index' => $index,
                                         'grid'=>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'purity',
                                         'controller' => 'metal_issue_vouchers',
                                         'index' => $index,
                                         'grid'=>'col-sm-12')); ?>
  </td>

  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_metal_issue_voucher'
                                     'controller' => 'metal_issue_vouchers',
                                     'index' => $index)); ?>
  </td>

</tr>