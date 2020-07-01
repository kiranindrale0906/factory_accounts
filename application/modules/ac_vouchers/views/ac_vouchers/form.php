<?php
  if (!isset($record)) $record = array();

  if(empty($action)) {
    $controller = $this->router->module."/".$this->router->class;
    $action = "store";
  }

  $checked = (!empty($record['has_hallmark'])) ? 'checked' : '';

  $readonly='';
  if ($this->router->class == "rate_cut_purchase_price_issue_vouchers"
      || $this->router->class == "rate_cut_purchase_price_receipt_vouchers"
      || $this->router->class == "rate_cut_purchase_weight_issue_vouchers"
      || $this->router->class == "rate_cut_purchase_weight_receipt_vouchers"
      || $this->router->class == "rate_cut_booking_price_issue_vouchers"
      || $this->router->class == "rate_cut_booking_price_receipt_vouchers"
      || $this->router->class == "rate_cut_booking_weight_issue_vouchers"
      || $this->router->class == "rate_cut_booking_weight_receipt_vouchers") {
    $readonly=true;
  }

  $this->load->view('ac_vouchers/ac_vouchers/company_error_message');
?>

<form method="post" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php 
    if ($action == 'edit' || $action == 'update'): 
      load_field('hidden', array('field' => 'id'));
    endif;
  ?>

  <?php load_view('ac_vouchers/ac_vouchers/fields/sales_voucher_number');
        load_view('ac_vouchers/ac_vouchers/fields/company_id'); ?>

  <div class="row">                                  
    <?php load_view('ac_vouchers/ac_vouchers/fields/voucher_date');
          load_view('ac_vouchers/ac_vouchers/fields/receipt_type'); 
          load_view('ac_vouchers/ac_vouchers/fields/dd_type');?>  
  </div>

  <div class="row">   
    <?php load_view('ac_vouchers/ac_vouchers/fields/from_account_name'); 
          load_view('ac_vouchers/ac_vouchers/fields/from_group_name'); 
          load_view('ac_vouchers/ac_vouchers/fields/department_name'); 
          load_view('ac_vouchers/ac_vouchers/fields/type'); ?>
  </div>

  <div class="row">      
    <?php load_view('ac_vouchers/ac_vouchers/fields/account_name'); 
          load_view('ac_vouchers/ac_vouchers/fields/to_group_name'); ?>
  </div>  

  <div class="row"> 
    <?php load_view('ac_vouchers/ac_vouchers/fields/group_name'); ?>
  </div>

  <div class="row"> 
    <?php load_view('ac_vouchers/ac_vouchers/fields/gst_number'); ?>
  </div> 

  <div class="row"> 
    <?php load_view('ac_vouchers/ac_vouchers/fields/gold_rate'); 
          load_view('ac_vouchers/ac_vouchers/fields/rate'); 
          load_view('ac_vouchers/ac_vouchers/fields/gold_rate_purity'); ?>
  </div>  

  <div class="row"> 
    <?php load_view('ac_vouchers/ac_vouchers/fields/payment_term'); ?>   
  </div>  

  <div class="row"> 
    <?php load_view('ac_vouchers/ac_vouchers/fields/has_hallmark');  
          load_view('ac_vouchers/ac_vouchers/fields/hallmark_number'); ?>    
  </div>  

  <div class="row">         
    <?php 
          load_view('ac_vouchers/ac_vouchers/fields/hook_kdm_purity'); 
          load_view('ac_vouchers/ac_vouchers/fields/quantity');  
          load_view('ac_vouchers/ac_vouchers/fields/bank_name');  
          load_view('ac_vouchers/ac_vouchers/fields/gold_weight');  
          load_view('ac_vouchers/ac_vouchers/fields/gold_weight_purity'); ?>
  </div>        
  
  <div class="row">  
    <?php load_view('ac_vouchers/ac_vouchers/fields/credit_amount', array('readonly' => $readonly));  
          load_view('ac_vouchers/ac_vouchers/fields/debit_amount', array('readonly' => $readonly));
          load_view('ac_vouchers/ac_vouchers/fields/amount');
          load_view('ac_vouchers/ac_vouchers/fields/cash_amount');
          load_view('ac_vouchers/ac_vouchers/fields/cash_bill'); ?>   
  </div>

  <div class="row">   
    <?php load_view('ac_vouchers/ac_vouchers/fields/cheque_number');
          load_view('ac_vouchers/ac_vouchers/fields/debit_weight', array('readonly' => $readonly));  
          load_view('ac_vouchers/ac_vouchers/fields/credit_weight', array('readonly' => $readonly));
          load_view('ac_vouchers/ac_vouchers/fields/interest_per_day'); ?>
    <?php
      if ($this->router->class == 'metal_receipt_vouchers') { 
        load_view('ac_vouchers/ac_vouchers/fields/factory_purity');
        load_view('ac_vouchers/ac_vouchers/fields/factory_fine');
      } else {
        load_view('ac_vouchers/ac_vouchers/fields/purity');
        load_view('ac_vouchers/ac_vouchers/fields/fine'); 
      }?>
  </div>        

  <div class="row">   
    <?php load_view('ac_vouchers/ac_vouchers/fields/arg_weight'); ?>
    <?php 
      if ($this->router->class == 'metal_receipt_vouchers') { 
        load_view('ac_vouchers/ac_vouchers/fields/purity');
        load_view('ac_vouchers/ac_vouchers/fields/fine');
      } else {
        load_view('ac_vouchers/ac_vouchers/fields/factory_purity');
        load_view('ac_vouchers/ac_vouchers/fields/factory_fine');
      }
      load_view('ac_vouchers/ac_vouchers/fields/lumpsum_amount');
      load_view('ac_vouchers/ac_vouchers/fields/transaction_type'); 
    ?>
  </div>  

  <div class="row">   
    <?php load_view('ac_vouchers/ac_vouchers/fields/narration'); ?>
  </div>

  <div class="row">   
    <?php load_view('ac_vouchers/ac_vouchers/fields/total'); ?>
  </div> 
  
  <br/> 
  
  <div class="row">   
    <?php load_view('ac_vouchers/ac_vouchers/fields/add_more'); ?>
  </div>
  
  <?php 
      $receipt_type=!empty($_GET['receipt_type'])?$_GET['receipt_type']:'';
    if ($this->router->class == "metal_receipt_vouchers" 
        && !in_array($receipt_type, array('ARC Finished Goods',
                                          'ARF Finished Goods',
                                          'AR Gold Refresh',
                                          'ARC Refresh',
                                          'ARF Refresh'))) 
      $this->load->view('transactions/metal_issue_vouchers/subform_list');
    if ($this->router->class == "purchase_vouchers") $this->load->view('transactions/purchase_vouchers/subform_list');
    if ($this->router->class == "sales_vouchers") $this->load->view('transactions/sales_vouchers/subform_list');
    if ($this->router->class == "sales_return_vouchers") $this->load->view('transactions/sales_return_vouchers/subform_list');
    //if ($this->router->class == "opening_stock_vouchers") $this->load->view('transactions/opening_stock_vouchers/subform_list');
    if ($this->router->class == "repair_vouchers") $this->load->view('transactions/repair_vouchers/subform_list');
    if ($this->router->class == "approval_vouchers") $this->load->view('transactions/approval_vouchers/subform_list');
  ?>

  <div class="row"> 
    <div class="col-sm-6"> 
      <?php
        $add_attr=array();
        if(!empty($action) && ($action=="store" || $action=="create")) {
          $add_attr=array('controller' => $controller,
                          'class' => 'btn_blue ajax_post',
                          'show_inline_form' => TRUE, 
                          'name' => 'SAVE',
                          'href' => ADMIN_PATH.$controller."/".$action);
          load_buttons('button', $add_attr); 
        } else {  
          $add_attr=array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue');
          load_buttons('submit', $add_attr); 
        } 
      ?> 
    </div>
  </div>  
</form>  
<script type="text/javascript">
  var controller_name = '<?php echo $this->router->class; ?>';
</script>
<br>