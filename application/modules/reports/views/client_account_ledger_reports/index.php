<?php //$this->load->view('ac_vouchers/ac_vouchers/company_error_message'); ?> 
<br>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group container">
        <div class="table-responsive m-t-20">
          <table class="table table-sm fixedthead table-default">
            <thead>
              <tr>
                <th>Account Name</th>
                <th class="text-right">Receipt Weight</th>
                <th class="text-right">Receipt Fine</th>
                <th class="text-right">Issue Weight</th>
                <th class="text-right">Issue Fine</th>
                <th class="text-right">Factory Receipt Fine</th>
                <th class="text-right">Factory Issue Fine</th>
                <th class="text-right">Different</th>
              </tr>
            </thead>
            <?php 
              if(!empty($trial_balance)) {
                $total_weight_receipt=0;
                $total_weight_issue=0;
                $total_fine_receipt=0;  
                $total_fine_issue=0;  
                $total_factory_fine_receipt=0;  
                $total_factory_fine_issue=0;  
                $total_different=0;  
                //pd($trial_balance);die;
                foreach ($trial_balance as  $record) {
                  if($record['receipt_weight']>0)
                    $total_weight_receipt=$total_weight_receipt+$record['receipt_weight'];
                  else 
                    $total_weight_issue=$total_weight_issue+$record['receipt_weight'];

                  if($record['fine']>0)
                    $total_fine_receipt=$total_fine_receipt+$record['fine'];
                  else 
                    $total_fine_issue=$total_fine_issue+$record['fine'];

                  if($record['factory_fine']>0)
                    $total_factory_fine_receipt=$total_factory_fine_receipt+$record['factory_fine'];
                  else 
                    $total_factory_fine_issue=$total_factory_fine_issue+$record['factory_fine'];

                  $total_factory_fine_issue=$total_factory_fine_issue+$record['factory_fine']; 
                  $total_different=$total_different+$record['different']; ?>

                    <tr>
                      <td><?=$record['account_name'];?></td>
                      <td class="text-right">
                        <?=($record['receipt_weight']>0)?$record['receipt_weight']:'';?>  
                      </td>
                      <td class="text-right"><?=($record['fine']>0)?four_decimal($record['fine']):'';?>  </td>
                      <td class="text-right"><?=($record['receipt_weight']<0)?four_decimal($record['receipt_weight']*-1):'';?></td>
                      <td class="text-right"><?=($record['fine']<0)?four_decimal($record['fine']*-1):'';?>  </td>
                      <td class="text-right"><?=($record['factory_fine']>0)?four_decimal($record['factory_fine']):'';?>  </td>
                      <td class="text-right"><?=($record['factory_fine']<0)?four_decimal($record['factory_fine']*-1):'';?>  </td>
                      <td class="text-right"><?=($record['different']!=0)?four_decimal($record['different']):''?>  </td>

                    </tr>
            <?php }
              } ?>
              <tr>
                <th>Total</th>
                <th class="text-right"><?=four_decimal($total_weight_receipt);?>  </th>
                <th class="text-right"><?=four_decimal($total_fine_receipt);?>  </th>
                <th class="text-right"><?=four_decimal($total_weight_issue*-1);?>  </th>
                <th class="text-right"><?=four_decimal($total_fine_issue*-1);?>  </th>
                <th class="text-right"><?=four_decimal($total_factory_fine_receipt);?>  </th>
                <th class="text-right"><?=four_decimal($total_factory_fine_issue);?>  </th>
                <th class="text-right"></th>

              </tr>
              <tr>
                <?php 
                  $total_weight_balance=0;
                  $total_fine_balance=0;
                  $total_factory_fine_balance=0;
                  $total_different_balance=0;
                  $total_weight_balance=$total_weight_receipt-($total_weight_issue*-1);
                  $total_fine_balance=$total_fine_receipt-($total_fine_issue*-1);
                  $total_factory_fine_balance=$total_factory_fine_receipt-($total_factory_fine_issue*-1);
                  $total_different_balance=$total_different;

                ?>
                <th>Balace</th>
                <th class="text-right">
                  <?=($total_weight_balance>0)?four_decimal($total_weight_balance):'';?>  
                </th>
                <th class="text-right">
                  <?=($total_fine_balance>0)?four_decimal($total_fine_balance):'';?>  
                </th>
                <th class="text-right">
                  <?=($total_weight_balance<0)?four_decimal($total_weight_balance*-1):'';?>  
                </th>
                <th class="text-right"><?=($total_fine_balance<0)?four_decimal($total_fine_balance*-1):'';?>  </th>
                <th class="text-right">
                  <?=($total_factory_fine_balance>0)?four_decimal($total_factory_fine_balance):'';?>  
                </th>
                <th class="text-right"><?=($total_factory_fine_balance<0)?four_decimal($total_factory_fine_balance*-1):'';?>  </th>

                <th><?=four_decimal($total_different);?></th>
              </tr>
          </table>
        </div>
        <div>
        <?php $assets=$liabilities=0;?>
          <b>Assets: <?=$assets=($total_weight_balance>0)?four_decimal($total_weight_balance):'';?>   </b><br>
          <b>Liabilities: <?=$liabilities=($total_factory_fine_balance<0)?four_decimal($total_factory_fine_balance*-1):'';?> </b><br>
          <b>Vadotar: <?=four_decimal($total_different);?> </b><br>
          <b>Different: <?=four_decimal($assets-$liabilities-$total_different);?> </b>

        </div>
      </div>
    </div>
  </div>