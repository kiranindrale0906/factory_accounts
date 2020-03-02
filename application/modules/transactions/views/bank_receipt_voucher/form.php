<?php
  if (!isset($record)) 
    $record = array();

  if(empty($action)) {
    $controller=$this->router->module."/".$this->router->class;
    $action="store";
  }
?>
<?php //$this->load->view('tabs') ?>  

<form method="post" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')) ?>
  <?php endif; ?>     
  <?php
    if(isset($sales_voucher_id) && $sales_voucher_id != ''):
      load_field('hidden', array('field' => 'sales_voucher_number',
                                 'value'=>@$sales_voucher_id));
    endif;   
    load_field('hidden',array('field' => 'company_id',
                              'value'=>($this->session->userdata('company_id')?$this->session->userdata('company_id'):1)));
  ?>

    <?php load_field('date',array('field' => 'voucher_date',
                                  'value'=>(!empty($record['voucher_date'])?date('d-m-Y',strtotime($record['voucher_date'])):date('d-m-Y')), 
                                  'class' => 'datepicker_js')) ?>
    <?php load_field('text', array('field' => 'bank_name',
                                   'class'=>'autocomplete')) ?>                               
    <?php load_field('text', array('field' => 'account_name',
                                   'class'=>'autocomplete')) ?> 
    <?php load_field('hidden', array('field' => 'account_id')); ?>                               
                                             
    <?php load_field('text', array('field' => 'debit_amount')) ?> 
    <?php load_field('text', array('field' => 'cheque_number')) ?>                                       
    <?php load_field('text', array('field' => 'narration')) ?>
 
  <div class="row"> 
    <div class="col-sm-6"> 
      <?php
        $add_attr=array();
        if(!empty($action) && ($action=="store" || $action=="create")) {
          $add_attr=array('controller' => $controller,'class'=>'ajax','show_inline_form'=>TRUE);
        }
        else { 
          $add_attr=array('controller' => $controller);
        }
      ?>    
      <?php load_field('submit', $add_attr) ?>
    </div>
  </div>  
</form>  
<script type="text/javascript">
  var account_name_list='<?php echo json_encode($account_names,true);?>';
  var bank_name_list='<?php echo json_encode($bank_names,true); ?>';
  var controller_name='<?php echo $this->router->class; ?>';
  //console.log(bank_name_list);
</script>