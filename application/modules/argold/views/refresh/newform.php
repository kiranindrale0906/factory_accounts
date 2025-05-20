<?php
  if (!isset($record)) 
    $record = array();
?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')); ?>
  <?php endif; ?>     
  <div class="row">    
    <?php load_field('text', array('field' => 'weight','readonly'=>'readonly'));?>
    <?php load_field('text', array('field' => 'purity','readonly'=>'readonly'));?>
    <?php load_field('text', array('field' => 'fine','readonly'=>'readonly'));?>
    <?php load_field('text', array('field' => 'factory_purity','readonly'=>'readonly'));?>
    <?php load_field('text', array('field' => 'factory_fine','readonly'=>'readonly'));?>
    <?php load_field('text', array('field' => 'rate'));?>
    <?php load_field('text',array('field' => 'manual_taxable_amount'));  ?>
    <?php load_field('dropdown', array('field' => 'site_name','option'=>array(array('id'=>'AR Gold (Apr 2024)','name'=>'AR Gold (Apr 2024)'),
                                                                              array('id'=>'ARF (Apr 2024)','name'=>'ARF (Apr 2024)'),
                                                                              array('id'=>'ARF (Aug 2024)','name'=>'ARF (Aug 2024)'),
                                                                              array('id'=>'ARC (Apr 2024)','name'=>'ARC (Apr 2024)'),
                                                                              array('id'=>'AR Gold ERP','name'=>'AR Gold ERP'),
                                                                              array('id'=>'ARF ERP','name'=>'ARF ERP'),
                                                                              array('id'=>'ARC ERP','name'=>'ARC ERP'),
                                                                              array('id'=>'ARNA BANGLE','name'=>'ARNA BANGLE'),
                                                                              array('id'=>'RND ERP','name'=>'RND ERP'),
                                                                              array('id'=>'Domestic Internal ERP','name'=>'Domestic Internal ERP')
)));?>
  
  </div>
    <?php $this->load->view('refresh_details/formlist');?>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>
