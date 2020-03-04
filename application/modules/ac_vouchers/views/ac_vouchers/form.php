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
    if(isset($sales_voucher_id) && $sales_voucher_id != ''):
      if(!empty(@get_field_attribute($this->router->class,'sales_voucher_number'))) : 
        load_field('hidden', array('field' => 'sales_voucher_number',
                                   'value'=>@$sales_voucher_id));
      endif;
    endif; 

    load_field('hidden',array('field' => 'company_id',
                              'value'=>($this->session->userdata('company_id')?$this->session->userdata('company_id'):1))); ?>

  <?php
        if(!empty(@get_field_attribute($this->router->class,'voucher_date'))) :
           load_field('date',array('field' => 'voucher_date',
                                  'value'=>(!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):date('d-m-Y')), 
                                  'class' => 'datepicker_js')); 
        endif; ?>

        
  <?php if(!empty(@get_field_attribute($this->router->class,'account_name'))) :
          load_field('text', array('field' => 'account_name', 'class' => 'autocomplete',
                                   'data-table'=>'ac_account','data-column'=>'name')); 
          //'option'=>@$account_names
          load_field('hidden', array('field' => 'account_id'));                               
        endif; ?> 
    
  <?php if(!empty(@get_field_attribute($this->router->class,'credit_amount'))) :
          load_field('text', array('field' => 'credit_amount')); 
        endif; ?>   

  <?php if(!empty(@get_field_attribute($this->router->class,'debit_amount'))) :
          load_field('text', array('field' => 'debit_amount')); 
        endif; ?> 

  <?php if(!empty(@get_field_attribute($this->router->class,'credit_weight'))) :
          load_field('text', array('field' => 'credit_weight')); 
        endif; ?> 
  
  <?php if(!empty(@get_field_attribute($this->router->class,'debit_weight'))) :
          load_field('text', array('field' => 'debit_weight')); 
        endif; ?> 

  <?php if(!empty(@get_field_attribute($this->router->class,'narration'))) :
          load_field('text', array('field' => 'narration')); 
        endif; ?>
 
  <?php if(!empty(@get_field_attribute($this->router->class,'purity'))) :
          load_field('text', array('field' => 'purity')); 
                                    
        endif; ?>
  <?php if(!empty(@get_field_attribute($this->router->class,'factory_purity'))) :
          load_field('text', array('field' => 'factory_purity')); 
                                    
        endif; ?>      
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