<div class="col-md-12">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Assets</th>
              <th class="text-right">Fine</th>
            </tr>
          </thead>
          <?php 
              $assets_fine = 0;  
              $assets_vadotar = 0;  
              $assets_amount = 0;  
              $assets_usd_amount = 0;  
              if(!empty($trial_balance_records)) {
                foreach ($trial_balance_records as $record) {
                  if (  ($record['fine']>=0 && $record['account_name'] != 'Tounch Loss Fine')
                      || ($record['account_name'] == 'VADOTAR')) continue;

                  if ($record['account_name'] == 'SALES ACCOUNT') $profit_and_loss['sales_account'] = $record;
                if (!empty($sales_accounts)) $profit_and_loss['sale_gst_accounts'] = $sales_accounts;
                    
                  $assets_vadotar = $assets_vadotar + $record['vadotar'];
                  $assets_fine = $assets_fine + $record['fine'];
                  $assets_amount= $assets_amount + $record['amount'];
                  $assets_usd_amount= $assets_usd_amount + @$record['usd_amount'];
                  if(round($record['fine'],2)!=0||round($record['amount'],2)!=0){
                   ?>

                  <tr>
                    <td><?= $record['account_name']; ?>
                      <?php if ($loss_account==1 && !empty($loss_to_date)) { ?>
                        <a href=<?= base_url()."argold/unrecovarable_account_records/store?from=view&receipt_account_name=".urlencode($record['account_name'])."&credit_weight=".four_decimal(-1 * $record['fine'])."&narration=".urlencode($record['account_name'])."&receipt_type=Unrecovarable&issue_account_name=".urlencode($record['unrecoverable_account_name'])."&parent_id=".$record['id']."&voucher_date=".$loss_to_date ?> 
                          target='_blank' onclick="return confirm('Do you want to add this in Unrecovarable?')" ><?=@$record['unrecoverable_account_name']?></a><?php echo'('.four_decimal(-1 * $record['fine'], '-').')'; ?>
                      <?php } ?>  
                    </td>
                    <td class="text-right"><?= four_decimal(-1 * $record['fine'], '-') ?></td>
                  </tr>
                <?php }
                }
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal(-1 * $assets_fine, '-'); ?></th>          
            </tr>
        </table>
      </div>      
    </div>
  </div>  
