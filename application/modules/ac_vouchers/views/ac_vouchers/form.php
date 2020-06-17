<?php
  if (!isset($record)) 
    $record = array();

  if(empty($action)) {
    $controller=$this->router->module."/".$this->router->class;
    $action="store";
  }


  $this->load->view('ac_vouchers/ac_vouchers/company_error_message');
?>

<?php
  if (!isset($record)) 
    $record = array();    
    $checked="";   
    if(!empty($record['has_hallmark']))
    {
      $checked='checked';
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
  <div class="row">                                  
  <?php
      $col='';
      $readonly='';
      $col='col-md-4';
      if($this->router->class == "rate_cut_purchase_price_issue_vouchers"||$this->router->class == "rate_cut_purchase_price_receipt_vouchers"||$this->router->class == "rate_cut_purchase_weight_issue_vouchers"||$this->router->class == "rate_cut_purchase_weight_receipt_vouchers"||$this->router->class == "rate_cut_booking_price_issue_vouchers"||$this->router->class == "rate_cut_booking_price_receipt_vouchers"||$this->router->class == "rate_cut_booking_weight_issue_vouchers"||$this->router->class == "rate_cut_booking_weight_receipt_vouchers"){
        $readonly='readonly';
      }

        if(!empty(get_field_attribute($this->router->class,'voucher_date'))) :
           load_field('date',array('field' => 'voucher_date',
                                  'col'=>$col,
                                  'value'=>(!empty($record['voucher_date'])?date('d M Y',strtotime($record['voucher_date'])):date('d M Y')), 
                                  'class' => '','readonlyinput'=>true)); 
        endif; ?>

         <?php if(!empty(get_field_attribute($this->router->class,'receipt_type'))) :
            load_field('dropdown', array('field' => 'receipt_type', 'option' => @$receipt_type ,
                                         'class' =>'receipt_type', 'col'=>$col)); 
            
            load_field('hidden', array('field' => 'account_id'));                               
          endif; ?>  
  </div>      
   <div class="row">   


    <?php if(!empty(get_field_attribute($this->router->class,'from_account_name'))) :
            load_field('text', array('field' => 'from_account_name',
                       'class' => 'autocomplete_list_selection',
                       'col'=>$col,
                       'data-table'=>'ac_account',
                       'data-column'=>'name',
                       'data-where_condition'=>'group_code=\'bank\'',
                       'data-list-title'=>'From Account Name')); 

            load_field('hidden', array('field' => 'from_account_id'));                               
          endif; ?> 
     <?php if(!empty(get_field_attribute($this->router->class,'from_group_name'))) :
            load_field('text', array('field' => 'from_group_name','class' => 'autocomplete_list_selection','data-table'=>'ac_groups','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'From Group Name'));


            load_field('hidden', array('field' => 'from_group_id'));                                
          endif; ?> 
        <?php if(!empty(get_field_attribute($this->router->class,'department_name'))) :
          load_field('text', array('field' => 'department_name',
                                   'class' => 'autocomplete_list_selection ',
                                   'data-table'=>'ac_department','data-column'=>'name', 
                                   'col'=>$col,
                                   'data-list-title'=>'Department Name')); 
        endif; ?>

        <?php if(!empty(get_field_attribute($this->router->class,'type'))) :
            load_field('text', array('field' => 'type',
                                     'class' => 'autocomplete_list_selection ',
                                     'data-table'=>'ac_type','data-column'=>'name', 
                                     'col'=>$col,'data-list-title'=>'Type'));                               
          endif; ?> 
    

   </div>
  <div class="row">      
    <?php if(!empty(get_field_attribute($this->router->class,'account_name'))) :
            load_field('text', array('field' => 'account_name',
                                     'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_account',
                                     'data-column'=>'name',
                                     'data-where_condition'=>'group_code!=\'bank\'',
                                     'col'=>$col,
                                     'data-list-title'=>'Account Name')); 

            load_field('hidden', array('field' => 'account_id'));                               
          endif; ?> 
    <?php if(!empty(get_field_attribute($this->router->class,'to_group_name'))) :
      load_field('text', array('field' => 'to_group_name', 
                               'data-table'=>'ac_groups',
                               'class' => 'autocomplete_list_selection',
                               'data-column'=>'name','col'=>$col,
                               'data-list-title'=>'To Group Name')); 

      load_field('hidden', array('field' => 'to_group_id'));                               
    endif; ?>
  
  </div>  

  <div class="row"> 
  <?php if(!empty(get_field_attribute($this->router->class,'group_name'))) :
            load_field('text', array('field' => 'group_name','col'=>$col,
                                      'class' => 'autocomplete_list_selection ',
                                     'data-table'=>'ac_groups','data-column'=>'name', 
                                     'data-list-title'=>'Group Name'
                                     ));                                
          endif; ?>
  </div> 
  <div class="row"> 
  <?php if(!empty(get_field_attribute($this->router->class,'gst_number'))) :
            load_field('text', array('field' => 'gst_number','col'=>$col,
                                     ));                                
          endif; ?>
  </div> 
  <div class="row"> 


    <?php if(!empty(get_field_attribute($this->router->class,'gold_rate'))) :
            load_field('text', array('field' => 'gold_rate','col'=>$col));                                
          endif; ?>
  <?php if(!empty(get_field_attribute($this->router->class,'rate'))) :
            load_field('text', array('field' => 'rate','col'=>$col,
                                     'data-list-title'=>'Rate'));                                
          endif; ?>
  <?php if(!empty(get_field_attribute($this->router->class,'gold_rate_purity'))) :
            load_field('text', array('field' => 'gold_rate_purity',
                                     'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_purity',
                                     'data-column'=>'purity',
                                     'col'=>$col,
                                     'data-list-title'=>'Gold Rate Purity'));                                
          endif; ?>    

  </div>        
  <div class="row"> 
  <?php if(!empty(get_field_attribute($this->router->class,'payment_term'))) :
            load_field('text', array('field' => 'payment_term',
                       'class' => 'autocomplete_list_selection',
                       'data-table'=>'ac_payment_terms',
                       'data-column'=>'terms',
                       'col'=>$col,
                       'data-list-title'=>'Payment Term'));                                
          endif; ?>    

  </div>  
   <div class="row"> 
  <?php if(!empty(get_field_attribute($this->router->class,'has_hallmark'))) :
             
      load_field('checkbox', 
           array('field' => 'has_hallmark',
                 'option'=> array(
                            array('value' => '1', 
                                  'checked'=>TRUE,
                                  'label' => 'Has Hallmark')
                                  ),
                            'checked'=>$checked,
                ));

          endif; ?> 
  <?php if(!empty(get_field_attribute($this->router->class,'hallmark_number'))) :
            load_field('text', array('field' => 'hallmark_number',
              'col'=>$col));                                
          endif; ?>    

  </div>        
  <div class="row">         
    <?php if(!empty(get_field_attribute($this->router->class,'dd_type'))) :
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
    load_field('text', array('field' => 'bank_name' ,'col'=>$col,'class'=>'autocomplete_list_selection',
                            'data-table'=>'ac_account','data-column'=>'name',
                            'data-where_condition'=>'group_code=\'bank\'','data-list-title'=>'Bank'));                     
    endif; ?>
    <?php if(!empty(get_field_attribute($this->router->class,'gold_weight'))) :
            load_field('text', array('field' => 'gold_weight',
                       'class' => 'autocomplete_list_selection',
                                     'data-table'=>'gold_weight','data-column'=>'name','col'=>$col,
                                     'data-list-title'=>'Gold Weight'));                                
          endif; ?> 
      <?php if(!empty(get_field_attribute($this->router->class,'gold_weight_purity'))) :
            load_field('text', array('field' => 'gold_weight_purity',
                                     'class' => 'autocomplete_list_selection',
                                     'data-table'=>'ac_purity',
                                     'data-column'=>'purity',
                                     'col'=>$col,
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
      load_field('text', array('field' => 'cash_amount', 'col'=>$col
                               )); 
    endif; ?> 

    <?php if(!empty(get_field_attribute($this->router->class,'cash_bill'))) :
      load_field('text', array('field' => 'cash_bill', 'col'=>$col,
                               'class' => 'autocomplete_list_selection',
                               'data-table'=>'ac_cash_bill','data-column'=>'name',
                               'data-list-title'=>'Cash/Bill' 
                                    )); 
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
      <?php if(!empty(get_field_attribute($this->router->class,'interest_per_day'))) :
          load_field('text', array('field' => 'interest_per_day',
                                   'col'=>$col));
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
  
      <?php if(!empty(get_field_attribute($this->router->class,'lumpsum_amount'))) :
    load_field('text', array('field' => 'lumpsum_amount' ,'col'=>$col));                     
    endif; ?>

    <?php if(!empty(get_field_attribute($this->router->class,'factory_fine'))) :
          load_field('text', array('field' => 'factory_fine', 'readonlyinput'=>'1', 'class'=>'factory_fine',
                                  'col'=>$col)); 
        endif; ?>       
        <?php if(!empty(get_field_attribute($this->router->class,'transaction_type'))) :
            load_field('text', array('field' => 'transaction_type', 'col'=>$col,'class' => 'autocomplete_list_selection',
                               'data-table'=>'ac_cash_bill','data-column'=>'name',
                               'data-list-title'=>'Transaction Type' 
                                    ));                                
          endif; ?>       
  </div>  
  <div class="row">   
    <?php if(!empty(get_field_attribute($this->router->class,'narration'))) :
            load_field('text', array('field' => 'narration',
              'col'=>$col,
              'class' => 'autocomplete_list_selection',
              'data-table'=>'ac_narration',
              'data-column'=>'name',
              'data-list-title'=>'Narration' 
                                    )); 
          endif; ?>
  </div>
  <div class="row">   
    <?php if(!empty(get_field_attribute($this->router->class,'total_gross_weight'))) :
            load_field('text', array('field' => 'total_gross_weight','readonly'=>'readonly','class'=>'get_total_gross_weight','col'=>$col)); 
          endif; ?>
    <?php if(!empty(get_field_attribute($this->router->class,'total_net_weight'))) :
            load_field('text', array('field' => 'total_net_weight','readonly'=>'readonly','class'=>'get_total_net_weight','col'=>$col)); 
          endif; ?>
    <?php if(!empty(get_field_attribute($this->router->class,'total_fine_weight'))) :
            load_field('text', array('field' => 'total_fine_weight','readonly'=>'readonly','class'=>'get_total_fine_weight','col'=>$col)); 
          endif; ?> 

    <?php if(!empty(get_field_attribute($this->router->class,'total_amount'))) :
            load_field('text', array('field' => 'total_amount','readonly'=>'readonly','class'=>'get_total_amount','col'=>$col)); 
          endif; ?>
  </div> 
  <br>
  <?php 
    if($this->router->class=="metal_receipt_vouchers") {
      $this->load->view('transactions/metal_issue_vouchers/subform_list');
    }
  ?>
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
    if($this->router->class=="opening_stock_vouchers") {
      $this->load->view('transactions/opening_stock_vouchers/subform_list');
    } 
    if($this->router->class=="repair_vouchers") {
      $this->load->view('transactions/repair_vouchers/subform_list');
    }
    if($this->router->class=="approval_vouchers") {
      $this->load->view('transactions/approval_vouchers/subform_list');
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