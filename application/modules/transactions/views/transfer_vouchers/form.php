<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data" action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
  <?php endif; ?>
    <div class="row">
      <?php 
          load_field('text', array('field' => 'account_name',
                                   'class' => 'autocomplete_list_selection',
                                   'data-table'=>'ac_account',
                                   'data-column'=>'name',
                                   'data-where_condition'=>'group_code!=\'bank\'',
                                   'data-list-title'=>'Account Name')); 

          load_field('hidden', array('field' => 'account_id'));
      ?>
      <?php load_field('date',array('field' => 'from_date', 'class' => 'datepicker_js', 'col'=>'col-sm-4'))?> 
      <?php load_field('date',array('field' => 'to_date', 'class' => 'datepicker_js', 'col'=>'col-sm-4'))?> 
      <div class="col-sm-4 align-self-center">
        <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
      </div>
    </div>
</form>
<?php
  if (!isset($record)) 
    $record = array();

?>
