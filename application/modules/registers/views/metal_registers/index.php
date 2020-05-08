<?php 
$show_heading = isset($view_type) && $view_type == 'combined_report' ? FALSE : TRUE;
if($show_heading){ ?>
  <div class="boxrow mb-2">
    <div class="float-left">
     <h6 class="heading blue bold text-uppercase mb-0"><?= @getTableSettings()['page_title']; ?></h6>
    </div>
  </div>
<?php } ?>
  <form class="fields-group-sm" action="<?=ADMIN_PATH."registers/metal_registers/index"?>">
    <div class="row">
      <?php load_field('date',array('field' => 'start_date','class' => 'datepicker_js start_date', 'col'=>'col-sm-4','value'=>date('d-m-Y',strtotime($start_date))));?>
      <?php load_field('date',array('field' => 'end_date','class' => 'datepicker_js end_date', 'col'=>'col-sm-4','value'=>date('d-m-Y',strtotime($end_date))));?>  
      <div class="col-sm-4 align-self-center">
        <?php load_buttons('submit', array('name' =>'Search','class'=>'btn-xs btn_blue mr-2')) ?> 
        <?php load_buttons('button', array('name' =>'Clear','class'=>'btn-xs btn_blue clear_btn')) ?>      
      </div>
    </div>
  </form> 


  <div class="table-responsive m-t-20">
    <?php
      if (!empty($all_purities)): ?>
      <?php
          $grand_credit = 0;
          $grand_debit = 0;
          $grand_balance = 0;
          foreach ($all_purities as $purity_key => $purity): ?>
          <h3>
              <?php if ($purity_key == 0): ?>

              <?php endif; ?>
              <?= $purity['purity'] ?>
          </h3>

          <table class="table table-sm fixedthead table-default">
              <?php $this->load->view('registers/metal_registers/table_header'); ?>
              <tbody>
                  <?php $this->load->view('registers/metal_registers/table_opening_balance',
                                          array('total_opening_credit'=>$purity['total_opening_credit'],
                                                'total_opening_debit'=>$purity['total_opening_debit'])); ?>
                  <?php
                  if (!empty($purity['metal_register'])) :
                      foreach ($purity['metal_register'] as $key => $value) :
                        $this->load->view('registers/metal_registers/table_body', array('voucher_date'=>$value['voucher_date'],
                                                                                        'voucher_number'=>$value['voucher_number'],
                                                                                        'account_name'=>$value['account_name'],
                                                                                        'credit_weight'=>$value['credit_weight'],
                                                                                        'debit_weight'=>$value['debit_weight'],
                                                                                        'narration'=>$value['narration'])); ?>
                        
                          <?php
                      endforeach;
                  else:
                      ?>
                      
                  <?php endif; ?>
              </tbody>

              <tfoot>
                  <tr>
                      <td class="text-right" colspan="3"><b>Total</b></td>
                      <td class="text-right"><b><?= decimal_number_format($purity['total_credit']) ?></b></td>
                      <td class="text-right"><b><?= decimal_number_format($purity['total_debit']) ?></b></td>
                      <td></td>
                  </tr>
                  <tr>
                      <td class="text-right" colspan="3"><b>Balance</b></td>
                      <?php if ($purity['balance'] < 0): ?>
                          <td></td>
                          <td class="text-right"><b><?= decimal_number_format($purity['balance']) ?></b></td>
                      <?php else: ?>
                          <td class="text-right"><b><?= decimal_number_format($purity['balance']) ?></b></td>
                          <td></td>
                      <?php endif; ?>
                      <td></td>
                  </tr>
              </tfoot>

          </table>
      <?php 
          $grand_credit += !empty($purity['total_credit'])?$purity['total_credit']:0;
          $grand_debit += !empty($purity['total_debit'])?$purity['total_debit']:0;
          $grand_balance += !empty($purity['balance'])?$purity['balance']:0;
      endforeach; ?>
      <table class="table table-bordered toggle-circle default footable-loaded footable">
              <tbody>
                  <tr>
                      <td class="text-right" width="58.7%"><b>Grand Total</b></td>
                      <td class="text-right" width="15.6%"><b><?=decimal_number_format($grand_credit)?></b></td>
                      <td class="text-right" width="15%"><b><?=decimal_number_format($grand_debit)?></td>
                      <td></td>
                  </tr>
                   <tr>
                      <td class="text-right" width="58.7%"><b>Balance</b></td>
                      <td class="text-right" width="15.6%"><b></b></td>
                      <td class="text-right" width="15%"><b><?=decimal_number_format($grand_balance)?></td>
                      <td></td>
                  </tr>
               </tbody>   
              
      </table>
  <?php else :  ?>
      <table class="table table-sm fixedthead table-default">
        <?php $this->load->view('registers/metal_registers/table_header'); ?>
        <?php $this->load->view('registers/metal_registers/no_records'); ?>
  <?php endif; ?>
</div>        
          
     
              
          