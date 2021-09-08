<!-- <tr class="table_opening_stock_voucher_<?= $index ?>">
  <td>
    <?php load_field('plain/text', array('field' => 'category',
                                             'controller' => 'opening_stock_voucher_details',
                                             'index' => $index,
                                             'class' => 'autocomplete_list_selection',
                                             'data-table'=>'ac_department_category',
                                             'data-column'=>'name',
                                             'data-list-title'=>'Department Category',
                                             
                                             'is_table'=>TRUE)); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'gross_wt',
                                         'controller' => 'opening_stock_voucher_details',
                                         'class' => 'gross_weight',
                                         'id' => 'gross_wt_'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'moti_wt',
                                         'controller' => 'opening_stock_voucher_details',
                                         'id' => 'moti_wt'.$index,
                                         'index' => $index,
                                         'grid'=> 'col-sm-12')); ?>
  </td>
   <td>
    <?php load_field('plain/text', array('field' => 'net_wt',
                                         'controller' => 'opening_stock_voucher_details',
                                         'id' => 'net_wt_'.$index,
                                         'index' => $index,
                                         'class' => 'net_weight',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'melting',
                                         'controller' => 'opening_stock_voucher_details',
                                         'id' => 'melting_'.$index,
                                         'index' => $index,
                                         'class' => 'melting',
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'wastage',
                                         'controller' => 'opening_stock_voucher_details',
                                         'id' => 'wastage_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'other_charges',
                                         'controller' => 'opening_stock_voucher_details',
                                         'id' => 'other_charges_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td><td>
    <?php load_field('plain/text', array('field' => 'description',
                                         'controller' => 'opening_stock_voucher_details',
                                         'id' => 'description_'.$index,
                                         'index' => $index,
                                         'grid' =>'col-sm-12')); ?>
  </td>
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_opening_stock_voucher('.$index.')',
                    array(
                     'controller' => 'opening_stock_voucher_details',
                     'index' => $index)); ?>
  </td>

</tr> -->