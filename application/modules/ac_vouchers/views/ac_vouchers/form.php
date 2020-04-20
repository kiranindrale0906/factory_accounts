<?php
  if (!isset($record)) 
    $record = array();

  if(empty($action)) {
    $controller=$this->router->module."/".$this->router->class;
    $action="store";
  }


  $this->load->view('ac_vouchers/ac_vouchers/company_error_message');
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
  <div class="row">                                  
  <?php
      $col='';
      $readonly='';
      if($this->router->class == "purchase_price_issue_vouchers"||$this->router->class == "purchase_price_receipt_vouchers"||$this->router->class == "purchase_weight_issue_vouchers"||$this->router->class == "purchase_weight_receipt_vouchers"){
        $readonly='readonly';
      }
        $col='col-md-4';

        if(!empty(get_field_attribute($this->router->class,'voucher_date'))) :
           load_field('date',array('field' => 'voucher_date',
                                  'value'=>(!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):date('d-m-Y')), 
                                  'class' => '','readonlyinput'=>true)); 
        endif; ?>
  </div>      
   <div class="row">   


    <?php if(!empty(get_field_attribute($this->router->class,'from_account_name'))) :
            load_field('text', array('field' => 'from_account_name', 'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_from_account','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'From Account Name')); 

            load_field('hidden', array('field' => 'from_account_id'));                               
          endif; ?> 
     <?php if(!empty(get_field_attribute($this->router->class,'from_group_name'))) :
            load_field('text', array('field' => 'from_group_name','col'=>$col,
                                     'data-list-title'=>'From Group Name')); 

            load_field('hidden', array('field' => 'from_group_id'));                               
          endif; ?> 
        <?php if(!empty(get_field_attribute($this->router->class,'department_name'))) :
            load_field('text', array('field' => 'department_name' ,'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_department','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Department Name')); 
          endif; ?>    

   </div>
  <div class="row">      
    <?php if(!empty(get_field_attribute($this->router->class,'account_name'))) :
            load_field('text', array('field' => 'account_name', 'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_account','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Account Name')); 

            load_field('hidden', array('field' => 'account_id'));                               
          endif; ?> 
    <?php if(!empty(get_field_attribute($this->router->class,'to_group_name'))) :
      load_field('text', array('field' => 'to_group_name', 'class' => 'autocomplete_list_selection',
                               'data-table'=>'ac_to_group','data-column'=>'name','col'=>$col,
                               'data-list-title'=>'To Group Name')); 

      load_field('hidden', array('field' => 'to_group_id'));                               
    endif; ?> 

    <?php if(!empty(get_field_attribute($this->router->class,'receipt_type'))) :
            load_field('dropdown', array('field' => 'receipt_type', 'option' => @$receipt_type ,
                                         'class' =>'receipt_type', 'col'=>$col)); 
            
            load_field('hidden', array('field' => 'account_id'));                               
          endif; ?> 
  
  </div>  


  <div class="row"> 
    <?php if(!empty(get_field_attribute($this->router->class,'gold_rate'))) :
            load_field('text', array('field' => 'gold_rate', 'class' => 'autocomplete_list_selection',
                                     'data-table'=>'gold_rate','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Gold Rate'));                                
          endif; ?>
  <?php if(!empty(get_field_attribute($this->router->class,'rate'))) :
            load_field('text', array('field' => 'rate','col'=>$col,
                                     'data-list-title'=>'Rate'));                                
          endif; ?>
  <?php if(!empty(get_field_attribute($this->router->class,'gold_rate_purity'))) :
            load_field('text', array('field' => 'gold_rate_purity', 'class' => 'autocomplete_list_selection',
                                     'data-table'=>'gold_rate_purity','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Gold Rate Purity'));                                
          endif; ?>    

  </div>        
  <div class="row">         
    <?php if(!empty(get_field_attribute($this->router->class,'type'))) :
            load_field('dropdown', array('field' => 'type', 'option' => @$daily_drawer_type,
                                         'col' => 'col-md-4 hide_daily_drawer_type'));                     
          endif; ?>        

    <?php if(!empty(get_field_attribute($this->router->class,'hook_kdm_purity'))) :
            load_field('dropdown', array('field' => 'hook_kdm_purity', 'option' => @$hook_kdm_purity,
                                         'col' => 'col-md-4 hide_hook_kdm_purity'));                     
          endif; ?>

    <?php if(!empty(get_field_attribute($this->router->class,'quantity'))) :
            load_field('text', array('field' => 'quantity' ,  'col'=>'col-md-4 hide_quantity'));                     
          endif; ?>

   <?php if(!empty(get_field_attribute($this->router->class,'bank_name'))) :
    load_field('text', array('field' => 'bank_name' ,'col'=>$col));                     
    endif; ?>
    <?php if(!empty(get_field_attribute($this->router->class,'gold_weight'))) :
            load_field('text', array('field' => 'gold_weight', 'class' => 'autocomplete_list_selection',
                                     'data-table'=>'gold_weight','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Gold Weight'));                                
          endif; ?> 
      <?php if(!empty(get_field_attribute($this->router->class,'gold_weight_purity'))) :
            load_field('text', array('field' => 'gold_weight_purity', 'class' => 'autocomplete_list_selection',
                                     'data-table'=>'gold_weight_purity','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Gold Weight Purity'));                                
          endif; ?> 
  </div>        
  <div class="row">  
    <?php if(!empty(get_field_attribute($this->router->class,'credit_amount'))) :
            load_field('text', array('field' => 'credit_amount' , 'col'=>$col,'readonly' => $readonly)); 
          endif; ?>   

    <?php if(!empty(get_field_attribute($this->router->class,'debit_amount'))) :
          load_field('text', array('field' => 'debit_amount', 'col'=>$col,'readonly' => $readonly)); 
        endif; ?> 

    <?php if(!empty(get_field_attribute($this->router->class,'amount'))) :
      load_field('text', array('field' => 'amount', 'col'=>$col)); 
    endif; ?> 
    <?php if(!empty(get_field_attribute($this->router->class,'cash_amount'))) :
      load_field('text', array('field' => 'cash_amount', 'col'=>$col)); 
    endif; ?> 
  </div>     
  <div class="row">   
  <?php if(!empty(get_field_attribute($this->router->class,'cheque_number'))) :
    load_field('text', array('field' => 'cheque_number' ,'col'=>$col));                     
    endif; ?>
    <?php if(!empty(get_field_attribute($this->router->class,'credit_weight'))) :
            load_field('text', array('field' => 'credit_weight', 'class'=>'credit_weight',
                                    'col'=>$col,'readonly' => $readonly)); 
          endif; ?> 
    
    <?php if(!empty(get_field_attribute($this->router->class,'debit_weight'))) :
            load_field('text', array('field' => 'debit_weight', 'class'=>'debit_weight',
                                     'col'=>$col,'readonly' => $readonly)); 
          endif; ?> 

    <?php if(!empty(get_field_attribute($this->router->class,'purity'))) :
          load_field('text', array('field' => 'purity',
                                   'class' => 'autocomplete_list_selection purity',
                                   'data-table'=>'ac_purity','data-column'=>'purity', 
                                   'col'=>$col,
                                   'data-list-title'=>'Purity')); 
        endif; ?>

    <?php if(!empty(get_field_attribute($this->router->class,'fine'))) :
          load_field('text', array('field' => 'fine', 'readonlyinput'=>'1', 'class'=>'fine',
                                  'col'=>$col)); 
        endif; ?>      
  </div>        

  <div class="row">   
    <?php
      if(!empty(get_field_attribute($this->router->class,'arg_weight'))) :
        load_field('text', array('field' => 'arg_weight', 'readonlyinput'=>'1', 
                                 'class'=>'arg_weight', 'id'=> 'arg_weight' ,'col'=>$col));  
      endif;  ?>

    <?php if(!empty(get_field_attribute($this->router->class,'factory_purity'))) :
          load_field('text', array('field' => 'factory_purity', 'class'=>'factory_purity',
                                  'col'=>$col));
        endif; ?>

    <?php if(!empty(get_field_attribute($this->router->class,'factory_fine'))) :
          load_field('text', array('field' => 'factory_fine', 'readonlyinput'=>'1', 'class'=>'factory_fine',
                                  'col'=>$col)); 
        endif; ?>       
        <?php if(!empty(get_field_attribute($this->router->class,'transaction_type'))) :
            load_field('dropdown', array('field' => 'transaction_type', 'option' => @$transaction_type ,
                                         'class' =>'transaction_type', 'col'=>$col));                                
          endif; ?>       
  </div>  
  <div class="row">   
    <?php if(!empty(get_field_attribute($this->router->class,'narration'))) :
            load_field('text', array('field' => 'narration')); 
          endif; ?>
  </div> 
  <br>
  <?php 
    if($this->router->class=="purchase_vouchers") {
      $this->load->view('transactions/purchase_vouchers/subform_list');
    }
    if($this->router->class=="sales_vouchers") {
      $this->load->view('transactions/sales_vouchers/subform_list');
    }
    if($this->router->class=="sales_return_vouchers") {
      $this->load->view('transactions/sales_return_vouchers/subform_list');
    }
  ?>
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
  var controller_name='<?php echo $this->router->class; ?>';
</script>
<br>