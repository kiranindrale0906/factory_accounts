<tr class="qr_codes_<?= $index ?>">
  <td>
    <?php load_field('plain/text', array('field' => 'gross_weight',
                                   'index' => $index,
                                   'onchange'=>'onchange_gross_weight('.$index.')',
                                   'horizontal'=>true,  
                                   'col'=>'col-lg-6 col-md-6',
                                   'controller' => 'qr_code_details',
                                   'form_group_class'=>'mb-0')); 
    ?>     
  </td>
  <td>
    <?php load_field('plain/text', array('field' => 'hu_id',
                                   'index' => $index,
                                   'horizontal'=>true,  
                                   'col'=>'col-lg-6 col-md-6',
                                   'controller' => 'qr_code_details',
                                   'form_group_class'=>'mb-0')); 
    ?>     
  </td>
  <td>
    <?php  load_field('plain/text', array('field' => 'net_weight',
                                   'index' => $index,
                                   'horizontal'=>true,  
                                   'readonly'=>'readonly',
                                   'col'=>'col-lg-6 col-md-6',
                                   'controller' => 'qr_code_details',
                                   'form_group_class'=>'mb-0')); 
    ?>     
  </td>
  <td>
    <?php  load_field('plain/text', array('field' => 'less',
                                   'index' => $index,
                                   'horizontal'=>true,
                                   'readonly'=>'readonly', 
                                   'col'=>'col-lg-6 col-md-6',
                                   'controller' => 'qr_code_details',
                                   'form_group_class'=>'mb-0')); 
    ?>     
  </td> 
  <td>
    <?php  load_field('plain/text', array('field' => 'total_stone',
                                   'index' => $index,
                                   'horizontal'=>true,
                                   'id'=>'stone_'.$index,
                                   'onchange'=>'change_total_stone('.$index.')', 
                                   'class'=>'change_total_stone',  
                                   'col'=>'col-lg-6 col-md-6',
                                   'id'=>$index,
                                   'controller' => 'qr_code_details',
                                   'form_group_class'=>'mb-0')); 
    ?>     
  </td>  

  <td>
    <?php  load_field('plain/text', array('field' => 'length',
                                   'index' => $index,
                                   'horizontal'=>true,  
                                   'col'=>'col-lg-6 col-md-6',
                                   'controller' => 'qr_code_details',
                                   'form_group_class'=>'mb-0')); 
    ?>     
  </td>
  <td>
    <?php  load_field('plain/text', array('field' => 'stone_count',
                                          'index' => $index,
                                          'horizontal'=>true,
                                          'id'=>'stone_'.$index,
                                          'col'=>'col-lg-6 col-md-6',
                                          'controller' => 'qr_code_details',
                                          'form_group_class'=>'mb-0')); 
    ?>     
  </td>
  <td>
    <?= getJsButton('Delete', 'javascript:void(0)', 'btn_red', '', 'delete_qr_codes('.$index.')'); ?>
    
  </td>

</tr>