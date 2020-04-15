<tr class="table_purchase_voucher_<?= $index ?>">
  <td>
    <?php load_field('plain/dropdown', array('field' => 'category',
                                             'option' => @$department_category,
                                             'controller' => 'purchase_voucher_details',
                                             'index' => $index,
                                             'is_table'=>TRUE)); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'gross_wt',
                                         'controller' => 'purchase_voucher_details',
                                         'class' => 'issue_gross_weight',
                                         'id' => 'gross_wt_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'moti_wt',
                                         'controller' => 'purchase_voucher_details',
                                         'id' => 'moti_wt'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
   <td>
    <?php load_field('plain/text', array('field' => 'net_wt',
                                         'controller' => 'purchase_voucher_details',
                                         'id' => 'net_wt_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'melting',
                                         'controller' => 'purchase_voucher_details',
                                         'id' => 'melting_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'wastage',
                                         'controller' => 'purchase_voucher_details',
                                         'id' => 'wastage_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'other_charges',
                                         'controller' => 'purchase_voucher_details',
                                         'id' => 'other_charges_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td><td>
    <?php load_field('plain/text', array('field' => 'description',
                                         'controller' => 'purchase_voucher_details',
                                         'id' => 'description_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_purchase_voucher('.$index.')',
                    array(
                     'controller' => 'purchase_voucher_details',
                     'index' => $index)); ?>
  </td>

</tr>