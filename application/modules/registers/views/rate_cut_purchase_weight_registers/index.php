<?php 
$show_heading = isset($view_type) && $view_type == 'combined_report' ? FALSE : TRUE;
if($show_heading){ ?>
  <div class="boxrow mb-2">
    <div class="float-left">
     <h6 class="heading blue bold text-uppercase mb-0"><?= @getTableSettings()['page_title']; ?></h6>
    </div>
  </div>
<?php } ?>
  <form class="fields-group-sm" action="<?=ADMIN_PATH."registers/cash_registers/index"?>">
    <div class="row">
      
      <?php load_field('text',array('field' => 'account_name',
                                     'class' => 'autocomplete_list_selection account_name',
                                     'data-table'=>'ac_account','data-list-title'=>'Account Name','data-column'=>'name',
                                     'col'=>'col-sm-4','value'=>@$account_name));?>
      <?php load_field('date',array('field' => 'start_date','class' => 'datepicker_js start_date', 'col'=>'col-sm-4','value'=>date('d-m-Y',strtotime($start_date))));?>
      <?php load_field('date',array('field' => 'end_date','class' => 'datepicker_js end_date', 'col'=>'col-sm-4','value'=>date('d-m-Y',strtotime($end_date))));?>  
      <div class="col-sm-4 align-self-center">
        <?php load_buttons('submit', array('name' =>'Search','class'=>'btn-xs btn_blue mr-2')) ?> 
        <?php load_buttons('button', array('name' =>'Clear','class'=>'btn-xs btn_blue clear_btn')) ?>      
      </div>
    </div>
  </form> 

<br>

<div class="table-responsive m-t-20">
  <table class="table table-sm fixedthead table-default">
  <?php 
    $this->load->view('registers/rate_cut_purchase_weight_registers/table_header');
    if(!empty($rate_cut_purchase_weight_registers))
      $this->load->view('registers/rate_cut_purchase_weight_registers/table_body');
    else
      $this->load->view('registers/rate_cut_purchase_weight_registers/no_records');
  ?>
  </table>
</div>
         
          
     
              
          