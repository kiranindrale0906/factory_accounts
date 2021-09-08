<tr class="table_approval_voucher_<?= $index ?>">
  <td>
    <?php load_field('plain/text', array('field' => 'category',
                                             'controller' => 'approval_voucher_details',
                                             'index' => $index,
                                             'class' => 'autocomplete_list_selection',
                                             'data-table'=>'ac_department_category',
                                             'data-column'=>'name',
                                             'data-list-title'=>'Department Category',
                                             
                                             'is_table'=>TRUE)); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'gross_wt',
                                         'controller' => 'approval_voucher_details',
                                         'class' => 'gross_weight',
                                         'id' => 'gross_wt_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'moti_wt',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'moti_wt'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
   <td>
    <?php load_field('plain/text', array('field' => 'net_wt',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'net_wt_'.$index,
                                         'index' => $index,
                                         'class' => 'net_weight',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'melting',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'melting_'.$index,
                                         'index' => $index,
                                         'class' => 'melting',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'wastage',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'wastage_'.$index,
                                         'index' => $index,
                                         'class' => 'wastage',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'rate',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'rate_'.$index,
                                         'index' => $index,
                                         'class' => 'rate',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'gold_amount',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'gold_amount_'.$index,
                                         'index' => $index,
                                         'class' => 'gold_amount',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'labour_rate',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'labour_rate_'.$index,
                                         'index' => $index,
                                         'class' => 'labour_rate',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'other_charges',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'other_charges_'.$index,
                                         'index' => $index,
                                         'class'=>'other_charges',
                                         'grid' =>'col-sm-12')); ?>
  </td><td>
    <?php load_field('plain/text', array('field' => 'description',
                                         'controller' => 'approval_voucher_details',
                                         'id' => 'description_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_approval_voucher('.$index.')',
                    array(
                     'controller' => 'approval_voucher_details',
                     'index' => $index)); ?>
  </td>

</tr>