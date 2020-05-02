<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$show_heading = isset($view_type) && $view_type == 'combined_report' ? FALSE : TRUE;
if($show_heading){ ?>
  <div class="boxrow mb-2">
    <div class="float-left">
     <h6 class="heading blue bold text-uppercase mb-0"><?= @getTableSettings()['page_title']; ?></h6>
    </div>
  </div>
<?php } ?>
  <form class="fields-group-sm">
    <div class="row">
      <?php load_field('date',array('field' => 'start_date','class' => 'datepicker_js start_date', 'col'=>'col-sm-4','value'=>date('d-m-Y',strtotime($start_date))));?>
      <?php load_field('date',array('field' => 'end_date','class' => 'datepicker_js end_date', 'col'=>'col-sm-4','value'=>date('d-m-Y',strtotime($end_date))));?>  
      <div class="col-sm-4 align-self-center">
        <?php load_buttons('button', array('name' =>'Search','class'=>'btn-xs btn_blue search_data mr-2')) ?> 
        <?php load_buttons('button', array('name' =>'Clear','class'=>'btn-xs btn_blue clear_btn')) ?>      
      </div>
    </div>
  </form> 

<!-- <div class="table-responsive m-t-20">
 <!--  <table class="table table-sm fixedthead table-default">
  <?php 
   // $this->load->view('registers/metal_registers/table_header');
   // $this->load->view('registers/metal_registers/table_body');
  ?>
  </table> -->
<!--</div> -->

  <div class="table-responsive m-t-20">


                    <?php //pd($all_purities); 
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

                            <table class="table table-bordered toggle-circle default footable-loaded footable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Voucher Number</th>
                                        <th>Account Name</th> 
                                        <th class="text-right">Credit Weight</th>
                                        <th class="text-right">Debit Weight</th>
                                        <th>Narration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Opening Balance</td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right"><?= overwrite_number_format($purity['total_opening_credit'], 3) ?></td>
                                        <td class="text-right"><?= overwrite_number_format($purity['total_opening_debit'], 3) ?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    if (!empty($purity['metal_register'])) :
                                        foreach ($purity['metal_register'] as $key => $value) :
                                            ?>
                                            <tr>
                                                <td><?= date('d-m-y', strtotime($value['voucher_date'])) ?></td>
                                                <td><?= $value['voucher_number'] ?></td>
                                                <td><?= $value['account_name'] ?></td>
                                                <td class="text-right"><?= overwrite_number_format($value['credit_weight'], 3) ?></td>
                                                <td class="text-right"><?= overwrite_number_format($value['debit_weight'], 3) ?></td>
                                                <td><?= (!empty($value['narration'])) ? $value['narration'] : '' ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr><td colspan="6"> No Record found.</td></tr>
                                    <?php endif; ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td class="text-right" colspan="3"><b>Total</b></td>
                                        <td class="text-right"><b><?= overwrite_number_format($purity['total_credit'], 3) ?></b></td>
                                        <td class="text-right"><b><?= overwrite_number_format($purity['total_debit'], 3) ?></b></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="3"><b>Balance</b></td>
                                        <?php if ($purity['balance'] < 0): ?>
                                            <td></td>
                                            <td class="text-right"><b><?= overwrite_number_format($purity['balance'], 3) ?></b></td>
                                        <?php else: ?>
                                            <td class="text-right"><b><?= overwrite_number_format($purity['balance'], 3) ?></b></td>
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
                                        <td class="text-right" width="15.6%"><b><?=overwrite_number_format($grand_credit,3)?></b></td>
                                        <td class="text-right" width="15%"><b><?=overwrite_number_format($grand_debit,3)?></td>
                                        <td></td>
                                    </tr>
                                     <tr>
                                        <td class="text-right" width="58.7%"><b>Balance</b></td>
                                        <td class="text-right" width="15.6%"><b></b></td>
                                        <td class="text-right" width="15%"><b><?=overwrite_number_format($grand_balance,3)?></td>
                                        <td></td>
                                    </tr>
                                 </tbody>   
                                
                        </table>
                    <?php endif; ?>
                </div>        
          
     
              
          