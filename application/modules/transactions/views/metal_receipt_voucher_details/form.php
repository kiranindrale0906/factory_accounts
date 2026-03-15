<?php
  if (!isset($record)) 
    $record = array();

  if(empty($action)) {
    $controller=$this->router->module."/".$this->router->class;
    $action="store";
  }
?>

<form method="post" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): 
          load_field('hidden', array('field' => 'id'));
        endif; ?>     
  <?php
    
    load_field('hidden',array('field' => 'company_id',
                              'value'=>($this->session->userdata('company_id')?$this->session->userdata('company_id'):1))); ?>
<div class="row"> 
  <?php load_field('date',array('field' => 'voucher_date',
                                  'readonly'=>'readonly',
                                  'value'=>(!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):date('d-m-Y')), 
                                  'class' => 'datepicker_js')); 
  ?>

   <?php load_field('text', array('field' => 'voucher_number',
                                  'readonly'=>'readonly',));                               
  ?>   
  </div>
  <div class="row">    
  <?php load_field('dropdown', array('field' => 'account_name', 'option'=>@$account_names)); 
        load_field('hidden', array('field' => 'account_id'));                               
  ?> 
  </div>
  <div class="row"> 
    
  <?php  load_field('text', array('field' => 'debit_weight')); 
  ?>  
  </div> 
  <div class="row"> 
   
  <?php load_field('text', array('field' => 'factory_purity',)); 
  ?>  
  <?php load_field('text', array('field' => 'factory_fine','readonly'=>'readonly')); 
  ?> 
  </div>
<div class="row"> 
  <?php load_field('text', array('field' => 'purity','col'=>'col-sm-4',)); 
  ?> 
  <?php load_field('text', array('field' => 'fine','readonly'=>'readonly')); 
  ?> 
  </div>
 
  <div class="row"> 
    <div class="col-sm-6"> 
      <?php
        $add_attr=array();
        if(!empty($action) && ($action=="store" || $action=="create")) {
          $add_attr=array('controller' => $controller,'class'=>'btn_blue ajax_post','show_inline_form'=>TRUE, 'name' => 'SAVE','href'=>ADMIN_PATH.$controller."/".$action);
          load_buttons('button', $add_attr); 
        }
        else {  
          $add_attr=array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue');
          load_buttons('submit', $add_attr); 
        } ?> 
    </div>
  </div>  
</form>  
<script type="text/javascript">
  var account_name_list='<?php echo json_encode(@$account_names,true);?>';
  var bank_name_list='<?php echo json_encode(@$bank_names,true); ?>';
  var controller_name='<?php echo $this->router->class; ?>';
  //console.log(bank_name_list);
</script>