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
                <th>Receipt Weight</th>
                <th>Receipt Fine</th>
                <th>Issue Weight</th>
                <th>Issue Fine</th>
              </tr>
            </thead>
            <?php 
              if(!empty($trial_balance)) {
                $total_weight_receipt=0;
                $total_weight_issue=0;
                $total_fine_receipt=0;  
                $total_fine_issue=0;  
                foreach ($trial_balance as  $record) { 
                  if($record['receipt_weight']>0)
                    $total_weight_receipt=$total_weight_receipt+$record['receipt_weight'];
                  else 
                    $total_weight_issue=$total_weight_issue+$record['receipt_weight'];

                  if($record['fine']>0)
                    $total_fine_receipt=$total_fine_receipt+$record['fine'];
                  else 
                    $total_fine_issue=$total_fine_issue+$record['fine']; ?> 
                    <tr>
                      <td class="text-right"><?=$record['account_name'];?></td>
                      <td class="text-right">
                        <?=($record['receipt_weight']>0)?four_decimal($record['receipt_weight']):'';?>  
                      </td>
                      <td class="text-right"><?=($record['fine']>0)?four_decimal($record['fine']):'';?>  </td>
                      <td class="text-right"><?=($record['receipt_weight']<0)?four_decimal($record['receipt_weight']*-1):'';?></td>
                      <td class="text-right"><?=($record['fine']<0)?four_decimal($record['fine']*-1):'';?>  </td>

                    </tr>
            <?php }
              } ?>
              <tr>
                <th>Total</th>
                <th class="text-right"><?=four_decimal($total_weight_receipt);?>  </th>
                <th class="text-right"><?=four_decimal($total_fine_receipt);?>  </th>
                <th class="text-right"><?=four_decimal($total_weight_issue*-1);?>  </th>
                <th class="text-right"><?=four_decimal($total_fine_issue*-1);?>  </th>

              </tr>
              <tr>
                <?php 
                  $total_weight_balance=0;
                  $total_fine_balance=0;
                  $total_weight_balance=$total_weight_receipt-($total_weight_issue);
                  $total_fine_balance=$total_fine_receipt-($total_fine_issue);

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
              </tr>
          </table>
        </div>
      </div>
    </div>
  </div>