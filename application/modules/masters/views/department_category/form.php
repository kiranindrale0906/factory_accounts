
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
  <?php endif; ?>     
   <?php load_field('hidden', 
             array('field' => 'company_id','value'=>(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):1))) ?>
  <div class="row">    
    <?php load_field('text', array('field' => 'name')) ?>
    <?php load_field('dropdown', array('field' => 'department_name_id',
                                              'option'=>@$department_name,
                                              'value'=>@$record['department_name_id'])) ?>
  </div>
  <div class="row">    
    <?php load_field('text', array('field' => 'melting')) ?>
    <?php load_field('text', array('field' => 'wastage')) ?>
  </div>
  <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 
                                     'class' => 'btn_blue')) ?>
</form>